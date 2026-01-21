<script>
    $(document).ready(function() {
        const productBody = $("#productBody");
        const discountInput = $("#inputDiscount");
        const shippingInput = $("#inputShipping");
        const grandTotalDisplay = $("#grandTotal");

        function updateSubtotal($row) {
            const qty = parseFloat($row.find(".qty-input").val()) || 1;
            const unitCost = parseFloat($row.find(".qty-input").data("cost")) || 0;
            const discount = parseFloat($row.find(".discount-input").val()) || 0;

            let subtotal = (unitCost * qty) - discount;
            subtotal = Math.max(subtotal, 0);

            $row.find(".subtotal").text(subtotal.toFixed(2));
            $row.find("input[name*='[subtotal]']").val(subtotal.toFixed(2));

            updateGrandTotal();
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            $(".subtotal").each(function() {
                const rawText = $(this).text().replace(/,/g, '');
                grandTotal += parseFloat(rawText) || 0;
            });

            const discount = parseFloat(discountInput.val()) || 0;
            const shipping = parseFloat(shippingInput.val()) || 0;

            grandTotal = grandTotal - discount + shipping;
            grandTotal = Math.max(grandTotal, 0);

            $('#grandTotal').text(`₹ ${grandTotal.toFixed(2)}`);
            $('#grand_total_input').val(grandTotal.toFixed(2));
        }


        function bindEvents() {
            $(".qty-input").off().on("input", function() {
                updateSubtotal($(this).closest("tr"));
            });

            $(".increment-qty").off().on("click", function() {
                const input = $(this).siblings(".qty-input");
                let value = parseInt(input.val()) || 0;
                input.val(value + 1);
                updateSubtotal($(this).closest("tr"));
            });

            $(".decrement-qty").off().on("click", function() {
                const input = $(this).siblings(".qty-input");
                let value = parseInt(input.val()) || 1;
                input.val(Math.max(value - 1, 1));
                updateSubtotal($(this).closest("tr"));
            });

            $(".discount-input").off().on("input", function() {
                updateSubtotal($(this).closest("tr"));
            });

            $(".remove-item").off().on("click", function() {
                $(this).closest("tr").remove();
                updateGrandTotal();
            });
        }

        // Modal for editing price/discount
        const modalHtml = `
        <div id="discountModal" class="modal fade" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <label>Unit Price</label>
                        <input type="number" id="modalPrice" class="form-control">
                        <label class="mt-2">Discount Type</label>
                        <select id="modalDiscountType" class="form-control">
                            <option value="fixed">Fixed</option>
                            <option value="percentage">Percentage</option>
                        </select>
                        <label class="mt-2">Discount</label>
                        <input type="number" id="modalDiscountValue" class="form-control">
                        <input type="hidden" id="editingRowId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="applyDiscountChanges">Apply</button>
                    </div>
                </div>
            </div>
        </div>
    `;
        $("body").append(modalHtml);

        $(document).on("click", ".edit-discount-btn", function() {
            const $row = $(this).closest("tr");
            const rowId = $row.data("id");
            const price = parseFloat($row.find(".net-cost").val()) || 0;
            const discount = parseFloat($row.find(".discount-input").val()) || 0;

            $("#modalPrice").val(price);
            $("#modalDiscountValue").val(discount);
            $("#modalDiscountType").val("fixed");
            $("#editingRowId").val(rowId);
            $("#discountModal").modal("show");
        });

        $("#applyDiscountChanges").on("click", function() {
            const rowId = $("#editingRowId").val();
            const updatedPrice = parseFloat($("#modalPrice").val()) || 0;
            const discountValue = parseFloat($("#modalDiscountValue").val()) || 0;
            const discountType = $("#modalDiscountType").val();

            const $row = $(`tr[data-id="${rowId}"]`);
            const qty = parseFloat($row.find(".qty-input").val()) || 1;

            let discountAmount = discountType === "percentage" ?
                (updatedPrice * qty * discountValue) / 100 :
                discountValue;

            $row.find(".net-cost").val(updatedPrice.toFixed(2));
            $row.find(".qty-input").attr("data-cost", updatedPrice);
            $row.find(".discount-input").val(discountAmount.toFixed(2));
            $row.find(`input[name*='[discount_type]']`).val(discountType);

            updateSubtotal($row);
            $("#discountModal").modal("hide");
        });

        // Grand total live updates
        discountInput.on("input", updateGrandTotal);
        shippingInput.on("input", updateGrandTotal);

        // AJAX Update Submit
        $('#purchaseUpdateForm').on('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const purchaseId = $('#purchase_id').val();
            let updateUrl = "{{ route('admin.purchase-return-update', ':id') }}".replace(':id',
                '{{ $editData->id }}');


            // Add spoofed PUT method for Laravel
            formData.append('_method', 'PUT');

            $('#spinner').removeClass('d-none');

            $.ajax({
                url: updateUrl,
                type: 'POST', // Laravel reads _method=PUT from form data
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#spinner').addClass('d-none');
                    if (res.status === 'success') {
                        showSuccessToast(res.message || 'Purchase updated successfully.');
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.all-purchase-return') }}";
                        }, 1500);
                    } else {
                        showToast("Unexpected error: " + res.message);
                    }
                },
                error: function(xhr) {
                    $('#spinner').addClass('d-none');
                    const errors = xhr.responseJSON?.errors;
                    if (errors) {
                        Object.values(errors).forEach(err => showToast(err[0]));
                    } else {
                        showToast("Something went wrong while updating.");
                    }
                }
            });
        });


        function showToast(message) {
            const toast = $(`
            <div class="toast align-items-center text-white bg-danger border-0 show" style="min-width:250px;margin-bottom:10px;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
                </div>
            </div>`);
            $("#toastBox").append(toast);
            setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
        }

        function showSuccessToast(message) {
            const toast = $(`
            <div class="toast align-items-center text-white bg-success border-0 show" style="min-width:250px;margin-bottom:10px;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"></button>
                </div>
            </div>`);
            $("#toastBox").append(toast);
            setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
        }

        $("body").append(`<div id="toastBox" style="position:fixed;top:20px;right:20px;z-index:1050;"></div>`);

        // Initial bindings
        bindEvents();
        updateGrandTotal();
    });
</script>
