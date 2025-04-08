/**
 * Function to add a footer to the PDF
 */
function addFooter(pdf) {
    const footerYPosition = pdf.internal.pageSize.height - 13;
    pdf.setDrawColor(79, 129, 189);
    pdf.setLineWidth(0.5);
    pdf.line(10, footerYPosition, 344, footerYPosition);

    const pageWidth = pdf.internal.pageSize.width;
    const currentDate = new Date();
    const options = { year: 'numeric', month: 'long' };
    const formattedDate = currentDate.toLocaleDateString(undefined, options);

    pdf.setFontSize(10);
    pdf.text(`Effective Date: ${formattedDate}`, pageWidth - 300, footerYPosition + 5, { align: "right" });

    const totalPages = pdf.internal.getNumberOfPages();
    for (let i = 1; i <= totalPages; i++) {
        pdf.setPage(i);
        pdf.text(`Page ${i} of ${totalPages}`, pageWidth - 12, footerYPosition + 5, { align: "right" });
    }
}