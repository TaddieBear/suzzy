/**
 * Function to add a table with data from the HTML table
 */
function addTable(pdf) {
    const table = document.getElementById("logsTable");
    const tableData = [];
    const headers = [];

    // Extract table headers
    table.querySelectorAll("thead tr th").forEach(th => {
        headers.push(th.innerText);
    });

    // Extract table body data
    table.querySelectorAll("tbody tr").forEach(tr => {
        const row = [];
        tr.querySelectorAll("td").forEach(td => {
            row.push(td.innerText);
        });
        tableData.push(row);
    });

    pdf.autoTable({
        head: [headers],
        body: tableData,
        theme: 'grid',
        startY: 40,
        margin: { left: 12 },
        styles: { 
            fontSize: 10, 
            valign: 'middle', 
            halign: 'center',
            lineColor: [0, 0, 0], // Black border color
            lineWidth: 0.05 // Thickness of table borders
        },
        columnStyles: { 
            0: { cellWidth: 30 },  
            1: { cellWidth: 80 }, 
            2: { cellWidth: 33 }, 
            3: { cellWidth: 60 }, 
            4: { cellWidth: 40 }, 
            5: { cellWidth: 40 } 
        },
        headStyles: { 
            fontSize: 11, 
            fontStyle: 'bold', 
            fillColor: false, // Transparent background
            textColor: [0, 0, 0], // Black text for contrast
            lineColor: [0, 0, 0], // Black header border
            lineWidth: 0.05
        }
    });
}
