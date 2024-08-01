window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    // const datatablesSimple = document.getElementById('datatablesSimple');
    // if (datatablesSimple) {
    //     new simpleDatatables.DataTable(datatablesSimple);

    // }
    const datatablesSimpleA = document.getElementById('datatablesSimpleA');
    if (datatablesSimpleA) {
        new simpleDatatables.DataTable(datatablesSimpleA, {
            perPageSelect: [2, 5, 10, 15, 20],
            perPage: 5,
            labels: {
                placeholder: "ស្វែងរក...",
                perPage: "",
                noRows: "មិនមានទិន្នន័យនៅក្នុងតារាងទេ",
                info: "Showing {start} to {end} of {rows}"
            },

        });
    }
    
   
    
})
window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    // const datatablesSimple = document.getElementById('datatablesSimple');
    // if (datatablesSimple) {
    //     new simpleDatatables.DataTable(datatablesSimple);

    // }
    // const datatablesSimpleQ = document.getElementById('datatablesSimpleQ');
    // if (datatablesSimpleQ) {
    //     new simpleDatatables.DataTable(datatablesSimpleQ, {
    //         perPage: 5,
    //         perPageSelect: [5, 10, 25],
    //         buttons: [
    //             {
    //                 text: 'Excel',
    //                 action: function () {
    //                     // Add functionality for Excel export
    //                     alert('Excel export functionality not implemented');
    //                 },
    //                 className: 'btn btn-success'
    //             },
    //             {
    //                 text: 'PDF',
    //                 action: function () {
    //                     // Add functionality for PDF export
    //                     alert('PDF export functionality not implemented');
    //                 },
    //                 className: 'btn btn-danger'
    //             },
    //             {
    //                 text: 'Print',
    //                 action: function () {
    //                     window.print();
    //                 },
    //                 className: 'btn btn-primary'
    //             }
    //         ]
    //     });
        
    // }
    
   
    
})

    
    
   
    



