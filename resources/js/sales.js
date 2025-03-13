// Función para imprimir el recibo
function printReceipt(saleId, subtotal, tax, total, saleDate, clientName, paymentMethod, saleDetails) {
    // Validar que los datos sean válidos
    saleId = saleId || 'N/A';
    subtotal = isNaN(parseFloat(subtotal)) ? 0 : parseFloat(subtotal);
    tax = isNaN(parseFloat(tax)) ? 0 : parseFloat(tax);
    total = isNaN(parseFloat(total)) ? 0 : parseFloat(total);
    saleDate = saleDate || new Date().toLocaleString();
    clientName = clientName || 'Cliente General';
    paymentMethod = paymentMethod || 'Efectivo';
    saleDetails = Array.isArray(saleDetails) ? saleDetails : [];

    // Formatear fecha y hora
    const formattedDate = new Date(saleDate).toLocaleDateString('es-CO', {
        year: 'numeric', 
        month: 'long', 
        day: 'numeric'
    });
    
    const formattedTime = new Date(saleDate).toLocaleTimeString('es-CO', {
        hour: '2-digit', 
        minute: '2-digit'
    });

    // Calcular el total de artículos
    const totalItems = saleDetails.reduce((sum, item) => sum + parseInt(item.quantity), 0);

    // Contenido del recibo optimizado para papel térmico
    const printContent = `
╔══════════════════════════════════╗
║          BICICLETERÍA            ║
║         "EL PEDALAZO"            ║
╚══════════════════════════════════╝

NIT: 123456789-0
Tel: 555-123-4567
Dir: Calle 123 #45-67, Ciudad

───────── RECIBO DE VENTA ─────────
No: ${saleId}
Fecha: ${formattedDate}
Hora: ${formattedTime}
Cliente: ${clientName}
Método de Pago: ${paymentMethod}
──────────────────────────────────────

PRODUCTOS:
${saleDetails.map((detail, index) => {
    const productName = detail.productName.length > 25 
        ? detail.productName.substring(0, 22) + '...' 
        : detail.productName;
    return `${(index+1).toString().padStart(2, '0')}. ${productName.padEnd(25, ' ')}
    ${detail.quantity.toString().padStart(2, ' ')} x $${Number(detail.price).toLocaleString('es-CO')} = $${Number(detail.subtotal).toLocaleString('es-CO')}`;
}).join('\n')}

──────────────────────────────────────
Items totales: ${totalItems}

Subtotal:          $${subtotal.toLocaleString('es-CO')}
IVA (19%):         $${tax.toLocaleString('es-CO')}
──────────────────────────────────────
TOTAL A PAGAR:     $${total.toLocaleString('es-CO')}
──────────────────────────────────────

¡Gracias por su compra!
Lo esperamos pronto

Visítenos en:
www.bicicleteriapedalazo.com
Instagram: @elpedalazo

Factura generada: ${new Date().toLocaleString('es-CO')}
    `;

    const printWindow = window.open('', '_blank', 'width=300,height=600');
    if (printWindow) {
        printWindow.document.write(`
            <html>
            <head>
                <title>Recibo de Venta #${saleId}</title>
                <meta charset="UTF-8">
                <style>
                    @page {
                        size: 80mm auto;  /* Ancho de papel térmico estándar */
                        margin: 0;
                    }
                    body {
                        font-family: 'Courier New', Courier, monospace;
                        font-size: 12px;
                        line-height: 1.3;
                        margin: 0;
                        padding: 5mm;
                        width: 70mm; /* Ancho útil de impresión */
                        color: #000;
                    }
                    pre {
                        white-space: pre-wrap;
                        margin: 0;
                        font-family: 'Courier New', Courier, monospace;
                    }
                    .no-print {
                        margin-top: 20px;
                        text-align: center;
                    }
                    @media print {
                        .no-print {
                            display: none;
                        }
                    }
                </style>
            </head>
            <body>
                <pre>${printContent}</pre>
                <div class="no-print">
                    <button onclick="window.print()">Imprimir Recibo</button>
                    <button onclick="window.close()">Cerrar</button>
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();
        
        // Impresión automática después de cargar la página
        printWindow.onload = function() {
            setTimeout(function() {
                printWindow.print();
                // No cerramos automáticamente para permitir reimpresión si es necesario
            }, 500);
        };
    } else {
        console.error('No se pudo abrir la ventana de impresión.');
        alert('No se pudo abrir la ventana de impresión. Revise la configuración de su navegador.');
    }
}

// Evento para capturar el clic del botón "Imprimir"
window.addEventListener('load', () => {
    console.log('Sistema de impresión inicializado');
    const printButtons = document.querySelectorAll('button[data-sale-id]');
    
    if (printButtons.length > 0) {
        printButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                const saleId = button.getAttribute('data-sale-id');
                const subtotal = parseFloat(button.getAttribute('data-subtotal')) || 0;
                const tax = parseFloat(button.getAttribute('data-tax')) || 0;
                const total = parseFloat(button.getAttribute('data-total')) || 0;
                const saleDate = button.getAttribute('data-sale-date');
                const clientName = button.getAttribute('data-client-name');
                const paymentMethod = button.getAttribute('data-payment-method');
                let saleDetails = [];

                try {
                    const detailsJson = button.getAttribute('data-sale-details');
                    saleDetails = detailsJson ? JSON.parse(detailsJson) : [];
                } catch (error) {
                    console.error('Error al parsear data-sale-details:', error);
                    saleDetails = [];
                }

                printReceipt(saleId, subtotal, tax, total, saleDate, clientName, paymentMethod, saleDetails);
            });
        });
    } else {
        console.warn('No se encontraron botones de impresión.');
    }
});