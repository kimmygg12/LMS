window.addEventListener('DOMContentLoaded', event => {
    // Simple-DataTables
    // https://github.com/fiduswriter/Simple-DataTables/wiki

    // const datatablesSimple = document.getElementById('datatablesSimple');
    // if (datatablesSimple) {
    //     new simpleDatatables.DataTable(datatablesSimple);

    // }
    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple, {
            perPageSelect: [2, 5, 10, 15, 20],
            perPage: 5,
            labels: {
                placeholder: "ស្វែងរក...",
                perPage: "",
                noRows: "មិនមានទិន្នន័យនៅក្នុងតារាងទេ",
                info: "Showing {start} to {end} of {rows}"
            }
        });
    }
})




