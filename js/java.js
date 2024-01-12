function ShowForm(punctID){
  switch(punctID) {
      case 'Фирмы':  
          $('#addFirmModal').modal('show');
          break;
      case 'Товары':  
          $('#addProductModal').modal('show');
          break;
      case 'Магазины':  
          $('#addStoreModal').modal('show');
          break;
      case 'Категории':  
          $('#addCategoryModal').modal('show');
          break;
      case 'Склады':  
          $('#addStorageModal').modal('show');
          break;
      case 'Пользователи':  
          $('#addUserModal').modal('show');
          break;
  }       
}

function editStore(data){
  $('#editStoreModal').modal('show');

  $('#name-store').val(data['name']);
  $('#address-store').val(data['address']);
  $('#hours_work-store').val(data['hours_work']);
  $('#phone-store').val(data['phone']);
  $('#last_name_admin-store').val(data['last_name_admin']);

  $('#editStoreModal').attr('data-id', data['id_store']);

}
function editPass(data){
    $('#editPassModal').modal('show');
    
    $('#editPassModal').attr('data-id', data['id_pass']);
  
  }

function editUser(data){
    $('#editUserModal').modal('show');
    $('#name-user').val(data['name']);
    $('#role').val(data['role']);

    $('#editUserModal').attr('data-id', data['id_user']);
  }

function editProduct(data){
  $('#editProductModal').modal('show');

  $('#store-product').val(data['id_store']);
  $('#category-product').val(data['id_category']);
  $('#firm-product').val(data['id_firm']);
  $('#name-product').val(data['product_name']);
  $('#description-product').val(data['descr']);
  $('#guarantee-product').val(data['guarantee']);
  $('#price-product').val(data['price']);

  if(data['credit']){
      $('#credit').val(1);
      $('#in_payment').val(data['in_payment']);
      $('#payment_for_month').val(data['payment_for_month']);
  } else {
      $('#credit').val(0);
      $('#in_payment').val(data[null]);
      $('#payment_for_month').val(null);
  }

  $('#editProductModal').attr('data-id', data['id_product']);
}

function editFirm(data){
  $('#editFirmModal').modal('show');
  $('#name-firm').val(data['name']);
  $('#country-firm').val(data['country']);
  $('#phone-firm').val(data['phone']);

  $('#editFirmModal').attr('data-id', data['id_firm']);

}
function editCategory(data){
  $('#editCategoryModal').modal('show');
  $('#name-category').val(data['name']);

  $('#editCategoryModal').attr('data-id', data['id_category']);

}

function editStorage(data){
  $('#editStorageModal').modal('show');
  $('#store-storage').val(data['id_store']);
  $('#address-storage').val(data['address']);

  $('#editStorageModal').attr('data-id', data['id_storage']);

}

function editCell(data){
    $('#editCellModal').modal('show');
    $('#count').val(data['count']);
  
    $('#editCellModal').attr('data-id', data['id_cell']);
  
  }

function deleteStore(rowId) {
      if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
          $.ajax({
              url: 'delete/delete_store.php',
              method: 'POST',
              data: {
                  id: rowId
              },
              success: function(response) {
                  if (response === 'success') {
                      location.reload();
                  } else {
                      alert(response);
                  }
              }
          });
      }
  }

function deleteUser(rowId) {
    if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
        $.ajax({
            url: 'delete/delete_user.php',
            method: 'POST',
            data: {
                id: rowId
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
}

function deleteProduct(rowId) {
      if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
          $.ajax({
              url: 'delete/delete_product.php',
              method: 'POST',
              data: {
                  id: rowId
              },
              success: function(response) {
                  if (response === 'success') {
                      location.reload();
                  } else {
                      alert(response);
                  }
              }
          });
      }
  }

function deleteFirm(rowId) {
    if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
        $.ajax({
            url: 'delete/delete_firm.php',
            method: 'POST',
            data: {
                id: rowId
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
}

function deleteCategory(rowId) {
    if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
        $.ajax({
            url: 'delete/delete_category.php',
            method: 'POST',
            data: {
                id: rowId
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
}


function deleteStorage(rowId) {
    if (confirm('Вы уверены, что хотите удалить строку с ID ' + rowId + '?')) {
        $.ajax({
            url: 'delete/delete_storage.php',
            method: 'POST',
            data: {
                id: rowId
            },
            success: function(response) {
                if (response === 'success') {
                    location.reload();
                } else {
                    alert(response);
                }
            }
        });
    }
}


$(document).ready(function () {
  $('#dtBasicExample').DataTable();
  $('.dataTables_length').addClass('bs-select');

  $('#credit').change(function () {
      var creditValue = $(this).val();

      if (creditValue == 1) {
          $('#creditForms').show();
          $('#creditForms').find('input,select').prop('disabled', false);

      } else {
          $('#creditForms').hide();
          $('#creditForms').find('input,select').prop('disabled', true);

      }
  });

  $('#storeFormUpdate').submit(function (e) {
      e.preventDefault();

      var recordId = $('#editStoreModal').attr('data-id');
      $('#id_store_update').val(recordId);
      $.ajax({
          url: 'update/update_store.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });

  
  $('#passFormUpdate').submit(function (e) {
    e.preventDefault();

    var recordId = $('#editPassModal').attr('data-id');
    $('#id_pass_update').val(recordId);
    $.ajax({
        url: 'update/update_pass.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                location.reload();
            } else {
                alert(response);
            }
        }
    });
});
  
  $('#productFormUpdate').submit(function (e) {
      e.preventDefault();
      var recordId = $('#editProductModal').attr('data-id');
      $('#id_product_update').val(recordId);
      $.ajax({
          url: 'update/update_product.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });


  $('#firmFormUpdate').submit(function (e) {
      e.preventDefault();
      var recordId = $('#editFirmModal').attr('data-id');
      $('#id_firm_update').val(recordId);
      $.ajax({
          url: 'update/update_firm.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });



  $('#categoryFormUpdate').submit(function (e) {
      e.preventDefault();
      var recordId = $('#editCategoryModal').attr('data-id');
      $('#id_category_update').val(recordId);
      $.ajax({
          url: 'update/update_category.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });

  $('#storageFormUpdate').submit(function (e) {
      e.preventDefault();
      var recordId = $('#editStorageModal').attr('data-id');
      $('#id_storage_update').val(recordId);
      $.ajax({
          url: 'update/update_storage.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });
  $('#cellFormUpdate').submit(function (e) {
    e.preventDefault();
    var recordId = $('#editCellModal').attr('data-id');
    $('#id_cell_update').val(recordId);
    $.ajax({
        url: 'update/update_cell.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                location.reload();
            } else {
                alert(response);
            }
        }
    });
});

$('#userFormUpdate').submit(function (e) {
    e.preventDefault();
    var recordId = $('#editUserModal').attr('data-id');
    $('#id_user_update').val(recordId);
    $.ajax({
        url: 'update/update_user.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                location.reload();
            } else {
                alert(response);
            }
        }
    });
});

  $('#firmFormAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: 'insert/insert_firm.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });
  $('#userFormAdd').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: 'insert/insert_user.php',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            if (response === 'success') {
                location.reload();
            } else {
                alert(response);
            }
        }
    });
});

  $('#storeFormAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: 'insert/insert_store.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });

  $('#categoryFormAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: 'insert/insert_category.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });

  $('#storageFormAdd').submit(function (e) {
      e.preventDefault();
      $.ajax({
          url: 'insert/insert_storage.php',
          method: 'POST',
          data: $(this).serialize(),
          success: function(response) {
              if (response === 'success') {
                  location.reload();
              } else {
                  alert(response);
              }
          }
      });
  });
  
});
  
  
  