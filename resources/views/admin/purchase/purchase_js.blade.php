   <script>
       $(document).ready(function() {
           $('#warehouse_id,#supplier_id').select2({
               placeholder: "Select Warehouse",
               allowClear: true,
               width: '100%'
           });

           const productSearchInput = $("#product_search");
           const warehouseDropdown = $("#warehouse_id");
           const productList = $("#product_list");
           const warehouseError = $("#warehouse_error");
           const orderItemsTableBody = $("#orderItemsTable tbody");
           const productSearchUrl = "{{ route('admin.purchase-products.search') }}";

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
                   query: query,
                   warehouse_id: warehouseId
               }, function(data) {
                   productList.html("");
                   if (data.length > 0) {
                       $.each(data, function(index, product) {
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
                   alert("Product already added.");
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
                       showToast(`Quantity cannot exceed available stock (${maxStock})`);
                       return;
                   }

                   if (qty < 1 || isNaN(qty)) {
                       $input.val(1);
                   }

                   updateSubtotal($row);
               });

               $(".increment-qty").off("click").on("click", function() {
                   const input = $(this).siblings(".qty-input");
                   const max = parseInt(input.attr("max"));
                   let value = parseInt(input.val());
                   if (value < max) {
                       input.val(value + 1);
                       updateSubtotal($(this).closest("tr"));
                   }
               });

               $(".decrement-qty").off("click").on("click", function() {
                   const input = $(this).siblings(".qty-input");
                   const min = parseInt(input.attr("min"));
                   let value = parseInt(input.val());
                   if (value > min) {
                       input.val(value - 1);
                       updateSubtotal($(this).closest("tr"));
                   }
               });

               $(".remove-product").off("click").on("click", function() {
                   $(this).closest("tr").remove();
                   updateGrandTotal();
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
           }

           $("#inputDiscount, #inputShipping").on("input", updateGrandTotal);

           // Modal HTML append
           let $modal = $(`
        <div id="customModal" style="position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:none;justify-content:center;align-items:center;z-index:1000;">
            <div style="background:white;padding:20px;border-radius:5px;width:400px;">
                <h3 id="modalTitle"></h3>
                <label>Product Price: <span class="text-danger">*</span></label>
                <input type="text" id="modalPrice" class="form-control" />
                <label>Discount Type: <span class="text-danger">*</span></label>
                <select id="modalDiscountType" class="form-control">
                    <option value="fixed">Fixed</option>
                    <option value="percentage">Percentage</option>
                </select>
                <label>Discount: <span class="text-danger">*</span></label>
                <input type="text" id="modalDiscount" class="form-control" value="0.00" />
                <div style="margin-top:15px;text-align:right;">
                    <button id="closeModal" class="btn btn-secondary">Close</button>
                    <button id="saveChanges" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    `);
           $("body").append($modal);

           function showModal(productName, productPrice, productId) {
               $("#modalTitle").text(productName);
               $("#modalPrice").val("₹ " + productPrice);
               $("#modalDiscount").val("0.00");
               $("#modalDiscountType").val("fixed");
               $("#customModal").data("id", productId).css("display", "flex");
           }

           $(document).on("click", ".edit-discount-btn", function(e) {
               e.preventDefault();
               const productId = $(this).data("id");
               const productName = $(this).data("name");
               const productPrice = $(this).data("cost");
               showModal(productName, productPrice, productId);
           });

           $(document).on("click", "#closeModal", function() {
               $("#customModal").hide();
           });

           $(document).on("click", "#saveChanges", function() {
               const updatedPrice = parseFloat($("#modalPrice").val().replace(/[₹\s]/g, "")) || 0;
               const discountValue = parseFloat($("#modalDiscount").val()) || 0;
               const discountType = $("#modalDiscountType").val();
               const productId = $("#customModal").data("id");

               const $row = $(`tr[data-id="${productId}"]`);
               if ($row.length) {
                   const $priceCell = $row.find("td").eq(1);
                   const $qtyInput = $row.find(".qty-input");
                   const $discountInput = $row.find(".discount-input");
                   const $subtotalCell = $row.find(".subtotal");

                   const qty = parseFloat($qtyInput.val()) || 1;

                   let discountAmount = 0;
                   if (discountType === "percentage") {
                       discountAmount = (updatedPrice * qty * discountValue) / 100;
                   } else {
                       discountAmount = discountValue;
                   }

                   let subtotal = (updatedPrice * qty) - discountAmount;
                   if (subtotal < 0) subtotal = 0;

                   $priceCell.html(`${updatedPrice.toFixed(2)}
                <input type="hidden" name="products[${productId}][cost]" value="${updatedPrice}">`);

                   $qtyInput.attr("data-cost", updatedPrice);
                   $discountInput.val(discountAmount.toFixed(2));
                   $row.find(`input[name="products[${productId}][discount_type]"]`).val(discountType);
                   $subtotalCell.text(subtotal.toFixed(2));

                   $("#customModal").hide();
                   updateGrandTotal();
               }
           });

           $("#inputDiscount").on("input", function() {
               $("#displayDiscount").text(this.value || 0);
           });

           $("#inputShipping").on("input", function() {
               $("#shippingDisplay").text(this.value || 0);
           });

           // Show Toastr
           $("body").append(`<div id="toastBox" style="position:fixed;top:20px;right:20px;z-index:1050;"></div>`);

           function showToast(message) {
               const toast = $(`
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" style="min-width:250px;margin-bottom:10px;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
               $("#toastBox").append(toast);
               setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
           }

           function showSuccessToast(message) {
               const toast = $(`
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" style="min-width:250px;margin-bottom:10px;">
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `);
               $("#toastBox").append(toast);
               setTimeout(() => toast.fadeOut(400, () => toast.remove()), 3000);
           }

           //  Store Data
           $('#purchaseForm').on('submit', function(e) {
               e.preventDefault();

               const formData = new FormData(this);
               $('#spinner').removeClass('d-none');

               $.ajax({
                   url: "{{ route('admin.purchase-store') }}",
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
                                   "{{ route('admin.all-purchase') }}";
                           }, 1500);
                       }
                   },
                   error: function(xhr) {
                       $('#spinner').addClass('d-none');
                       let errors = xhr.responseJSON.errors;
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
