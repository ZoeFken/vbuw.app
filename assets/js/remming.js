$(document).ready(function() {

    // ga door al de modal's
    $('button.next').on('click', function() {
        let dialog = $(this).closest('.modal');
        dialog.modal('hide');
        dialog.next().modal('show');
    });
    $('button.prev').on('click', function() {
        let dialog = $(this).closest('.modal');
        dialog.modal('hide');
        dialog.prev().modal('show');
    });
  
  
    $('#add').click(function() { 
        var emptyInfo = ["", "808811111111", "147", "0", "220", "220", "0", "0", "0", "47", "OGPA"];
        var tbodyRef = document.getElementById('remming').getElementsByTagName('tbody')[0];
        // Insert a row at the end of table
        var newRow = tbodyRef.insertRow();
        
        // Populate new row
        emptyInfo.forEach(addCells);
        function addCells(item, index) {
            var newCell = newRow.insertCell();
            var newText = document.createTextNode(item);
            newCell.appendChild(newText);
        }
        // newCell.appendChild(newText);
    });
  
});