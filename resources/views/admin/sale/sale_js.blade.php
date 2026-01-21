<script>
    $(document).ready(function() {
        // Select2 init
        $('#warehouse_id, #customer_id').select2({
            placeholder: "Select",
            allowClear: true,
            width: '100%'
        });

        // Define DOM elements
        const productSearchInput = $("#product_search");
        const warehouseDropdown = $("#warehouse_id");
        const productList = $("#product_list");
        const warehouseError = $("#warehouse_error");
        const orderItemsTableBody = $("#salesTable tbody");
        const productSearchUrl = "{{ route('admin.purchase-products.search') }}";

        // Due Validation
        $("input[name='paid_amount']").on("keydown", function(e) {
            const grandTotal = parseFloat($("input[name='grand_total']").val()) || 0;
            const paidAmount = parseFloat($(this).val()) || 0;

            if (paidAmount > grandTotal && e.key === "Enter") {
                e.preventDefault();
                showToast("Paid amount cannot exceed grand total.");
            }
        });


        // Search Product
        productSearchInput.on("keyup", function() {
            const query = $(this).val();
            const warehouseId = warehouseDropdown.val();

            if (!warehouseId) {
                warehouseError.removeClass('d-none');
                productList.html("");
                return;
            } else {
                warehouseError.addClass('d-none');
            }

            if (query.length > 1) {
                fetchProducts(query, warehouseId);
            } else {
                productList.html("");
            }
        });

        function fetchProducts(query, warehouseId) {
            $.get(productSearchUrl, {
                query,
                warehouse_id: warehouseId
            }, function(data) {
                productList.html("");
                if (data.length > 0) {
                    data.forEach(product => {
                        const item = `
                        <a href="#" class="list-group-item list-group-item-action product-item"
                            data-id="${product.id}"
                            data-code="${product.code}"
                            data-name="${product.name}"
                            data-cost="${product.price}"
                            data-stock="${product.product_qty}">
                            ${product.code} - ${product.name}
                        </a>`;
                        productList.append(item);
                    });

                    $(".product-item").on("click", function(e) {
                        e.preventDefault();
                        addProductToTable($(this));
                    });
                } else {
                    productList.html('<p class="text-muted">No Product Found</p>');
                }
            });
        }

        function addProductToTable($product) {
            const productId = $product.data("id");
            const productCode = $product.data("code");
            const productName = $product.data("name");
            const netUnitCost = parseFloat($product.data("cost"));
            const stock = parseInt($product.data("stock"));

            if ($(`tr[data-id="${productId}"]`).length > 0) {
                showToast("Product already added.");
                return;
            }

            const row = `
            <tr data-id="${productId}">
                <td>
                    ${productCode} - ${productName}
                    <button type="button" class="btn btn-primary btn-sm edit-discount-btn"
                        data-id="${productId}" 
                        data-name="${productName}" 
                        data-cost="${netUnitCost}">
                        <span class="mdi mdi-book-edit"></span>
                    </button>
                    <input type="hidden" name="products[${productId}][id]" value="${productId}">
                    <input type="hidden" name="products[${productId}][name]" value="${productName}">
                    <input type="hidden" name="products[${productId}][code]" value="${productCode}">
                </td>
                <td>
                    ${netUnitCost.toFixed(2)}
                    <input type="hidden" name="products[${productId}][cost]" value="${netUnitCost}">
                </td>
                <td style="color:#ffc121">${stock}</td>
                <td>
                    <div class="input-group">
                        <button class="btn btn-outline-secondary decrement-qty" type="button">−</button>
                        <input type="text" class="form-control text-center qty-input"
                            name="products[${productId}][quantity]" value="1" min="1" max="${stock}"
                            data-cost="${netUnitCost}" style="width: 30px;">
                        <button class="btn btn-outline-secondary increment-qty" type="button">+</button>
                    </div>
                </td>
                <td>
                    <input type="number" class="form-control discount-input"
                        name="products[${productId}][discount]" value="0" min="0" style="width:100px">
                    <input type="hidden" name="products[${productId}][discount_type]" value="fixed">
                </td>
                <td class="subtotal">${netUnitCost.toFixed(2)}</td>
                <td><button class="btn btn-danger btn-sm remove-product"><span class="mdi mdi-delete-circle mdi-18px"></span></button></td>
            </tr>`;

            orderItemsTableBody.append(row);
            productList.html("");
            productSearchInput.val("");
            updateEvents();
            updateGrandTotal();
        }

        function updateEvents() {
            $(".qty-input").off("input").on("input", function() {
                const $input = $(this);
                const $row = $input.closest("tr");
                const maxStock = parseInt($input.attr("max")) || 0;
                let qty = parseInt($input.val());

                if (qty > maxStock) {
                    $input.val(maxStock);
                    showToast(`Quantity cannot exceed stock (${maxStock})`);
                } else if (qty < 1 || isNaN(qty)) {
                    $input.val(1);
                }

                updateSubtotal($row);
            });

            $(".increment-qty, .decrement-qty").off("click").on("click", function() {
                const input = $(this).siblings(".qty-input");
                const max = parseInt(input.attr("max"));
                const min = parseInt(input.attr("min")) || 1;
                let value = parseInt(input.val());

                if ($(this).hasClass("increment-qty") && value < max) {
                    input.val(value + 1);
                }
                if ($(this).hasClass("decrement-qty") && value > min) {
                    input.val(value - 1);
                }

                updateSubtotal($(this).closest("tr"));
            });

            $(".remove-product").off("click").on("click", function() {
                $(this).closest("tr").remove();
                updateGrandTotal();
            });

            $(".discount-input").off("input").on("input", function() {
                updateSubtotal($(this).closest("tr"));
            });
        }

        function updateSubtotal($row) {
            const qty = parseFloat($row.find(".qty-input").val()) || 1;
            const unitCost = parseFloat($row.find(".qty-input").data("cost")) || 0;
            const discount = parseFloat($row.find(".discount-input").val()) || 0;

            let subtotal = (unitCost * qty) - discount;
            if (subtotal < 0) subtotal = 0;

            $row.find(".subtotal").text(subtotal.toFixed(2));
            updateGrandTotal();
        }

        function updateDueAmount() {
            const grandTotal = parseFloat($("input[name='grand_total']").val()) || 0;
            const paidAmount = parseFloat($("input[name='paid_amount']").val()) || 0;
            let due = grandTotal - paidAmount;
            if (due < 0) due = 0;

            $("#dueAmount").text(`₹ ${due.toFixed(2)}`);
            $("input[name='due_amount']").val(due.toFixed(2));
        }

        function updateGrandTotal() {
            let grandTotal = 0;
            $(".subtotal").each(function() {
                grandTotal += parseFloat($(this).text()) || 0;
            });

            const discount = parseFloat($("#inputDiscount").val()) || 0;
            const shipping = parseFloat($("#inputShipping").val()) || 0;
            grandTotal = grandTotal - discount + shipping;
            if (grandTotal < 0) grandTotal = 0;

            $("#grandTotal").text(`₹ ${grandTotal.toFixed(2)}`);
            $("input[name='grand_total']").val(grandTotal.toFixed(2));

            updateDueAmount();
        }

        $("#inputDiscount, #inputShipping").on("input", function() {
            updateGrandTotal();
        });

        $("input[name='paid_amount']").on("input", function() {
            const paidInput = $(this);
            const grandTotal = parseFloat($("input[name='grand_total']").val()) || 0;
            const paidAmount = parseFloat(paidInput.val()) || 0;

            if (paidAmount > grandTotal) {
                paidInput.addClass("is-invalid");
            } else {
                paidInput.removeClass("is-invalid");
            }

            updateDueAmount();
        });


        // Modal logic
        const $modal = $(`
        <div id="customModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:none;justify-content:center;align-items:center;z-index:1000;">
            <div style="background:white;padding:20px;border-radius:5px;width:400px;">
                <h3 id="modalTitle"></h3>
                <label>Product Price:</label>
                <input type="text" id="modalPrice" class="form-control" />
                <label>Discount Type:</label>
                <select id="modalDiscountType" class="form-control">
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
                <label>Discount:</label>
                <input type="text" id="modalDiscount" class="form-control" />
                <div class="text-end mt-3">
                    <button id="closeModal" class="btn btn-secondary">Close</button>
                    <button id="saveChanges" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>`);
        $("body").append($modal);

        $(document).on("click", ".edit-discount-btn", function() {
            const id = $(this).data("id");
            const name = $(this).data("name");
            const cost = $(this).data("cost");
            $("#modalTitle").text(name);
            $("#modalPrice").val(cost.toFixed(2));
            $("#modalDiscount").val("0.00");
            $("#modalDiscountType").val("fixed");
            $("#customModal").data("id", id).fadeIn();
        });

        $("#closeModal").on("click", function() {
            $("#customModal").fadeOut();
        });

        $("#saveChanges").on("click", function() {
            const id = $("#customModal").data("id");
            const updatedPrice = parseFloat($("#modalPrice").val()) || 0;
            const discountValue = parseFloat($("#modalDiscount").val()) || 0;
            const discountType = $("#modalDiscountType").val();

            const $row = $(`tr[data-id="${id}"]`);
            const $qtyInput = $row.find(".qty-input");
            const qty = parseFloat($qtyInput.val()) || 1;
            let discountAmount = 0;

            if (discountType === "percentage") {
                discountAmount = (updatedPrice * qty * discountValue) / 100;
            } else {
                discountAmount = discountValue;
            }

            let subtotal = (updatedPrice * qty) - discountAmount;
            if (subtotal < 0) subtotal = 0;

            $row.find("td").eq(1).html(
                `${updatedPrice.toFixed(2)}<input type="hidden" name="products[${id}][cost]" value="${updatedPrice}">`
            );
            $qtyInput.attr("data-cost", updatedPrice);
            $row.find(".discount-input").val(discountAmount.toFixed(2));
            $row.find(`input[name="products[${id}][discount_type]"]`).val(discountType);
            $row.find(".subtotal").text(subtotal.toFixed(2));
            updateGrandTotal();
            $("#customModal").fadeOut();
        });

        // Display discount/shipping live update
        $("#inputDiscount").on("input", function() {
            $("#displayDiscount").text(`₹ ${parseFloat(this.value || 0).toFixed(2)}`);
        });
        $("#inputShipping").on("input", function() {
            $("#shippingDisplay").text(`₹ ${parseFloat(this.value || 0).toFixed(2)}`);
        });

        // Toast functions
        function showToast(msg) {
            const toast = $(`<div class="toast text-white bg-danger show" style="min-width:250px;margin-bottom:10px;">
            <div class="toast-body d-flex justify-content-between align-items-center">
                ${msg}
                <button class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
        </div>`);
            $("#toastBox").append(toast);
            setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
        }

        function showSuccessToast(msg) {
            const toast = $(`<div class="toast text-white bg-success show" style="min-width:250px;margin-bottom:10px;">
            <div class="toast-body d-flex justify-content-between align-items-center">
                ${msg}
                <button class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
            </div>
        </div>`);
            $("#toastBox").append(toast);
            setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
        }

        $("body").append(`<div id="toastBox" style="position:fixed;top:20px;right:20px;z-index:1050;"></div>`);

        // Form submit
        $('#saleForm').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            $('#spinner').removeClass('d-none');

            $.ajax({
                url: "{{ route('admin.sales-store') }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function(res) {
                    $('#spinner').addClass('d-none');
                    if (res.status === 'success') {
                        showSuccessToast(res.message);
                        setTimeout(() => {
                            window.location.href =
                                "{{ route('admin.sale.items-list') }}";
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    $('#spinner').addClass('d-none');
                    const errors = xhr.responseJSON.errors;
                    if (errors) {
                        Object.values(errors).forEach(err => showToast(err[0]));
                    } else {
                        showToast("Something went wrong. Please try again.");
                    }
                }
            });
        });
    });
</script>
