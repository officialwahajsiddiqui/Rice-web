"use strict";

// Checkbox group handling
$("[data-checkboxes]").each(function () {
  var me = $(this),
    group = me.data('checkboxes'),
    role = me.data('checkbox-role');

  me.change(function () {
    var all = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"])'),
      checked = $('[data-checkboxes="' + group + '"]:not([data-checkbox-role="dad"]):checked'),
      dad = $('[data-checkboxes="' + group + '"][data-checkbox-role="dad"]'),
      total = all.length,
      checked_length = checked.length;

    if (role == 'dad') {
      if (me.is(':checked')) {
        all.prop('checked', true);
      } else {
        all.prop('checked', false);
      }
    } else {
      if (checked_length >= total) {
        dad.prop('checked', true);
      } else {
        dad.prop('checked', false);
      }
    }
  });
});

// Function to initialize DataTable if not initialized already
function initializeDataTable(selector, options) {
  if (!$.fn.dataTable.isDataTable(selector)) {
    $(selector).DataTable(options);
  }
}

// Initialize DataTables with custom settings
$(document).ready(function() {
  // Table 1 - disable sorting on columns 2 and 3
  initializeDataTable("#table-1", {
    "columnDefs": [
      { "sortable": false, "targets": [2, 3] }
    ]
  });

  // Table 2 - disable sorting on columns 0, 2, and 3, set default order by column 1 (ascending)
  initializeDataTable("#table-2", {
    "columnDefs": [
      { "sortable": false, "targets": [0, 2, 3] }
    ],
    "order": [[1, "asc"]] // zero-based column index
  });

  // Table with horizontal scrolling and state saving
  initializeDataTable('#save-stage', {
    "scrollX": true,
    "stateSave": true
  });

  // Table with export buttons (copy, csv, excel, pdf, print)
  initializeDataTable('#tableExport', {
    dom: 'Bfrtip',
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  });
});




