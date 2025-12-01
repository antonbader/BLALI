document.addEventListener('DOMContentLoaded', function() {
    const tables = document.querySelectorAll('table.sortable');

    tables.forEach(table => {
        const headers = table.querySelectorAll('th.sort-header');

        headers.forEach((header, index) => {
            header.style.cursor = 'pointer';
            header.addEventListener('click', () => {
                const type = header.dataset.type || 'string';
                const asc = !header.classList.contains('asc');

                // Reset classes
                headers.forEach(h => h.classList.remove('asc', 'desc'));
                header.classList.add(asc ? 'asc' : 'desc');

                sortTable(table, index, type, asc);
            });
        });

        // Add filter input if table has class filterable
        if (table.classList.contains('filterable')) {
            const filterRow = document.createElement('tr');
            filterRow.classList.add('filter-row');

            // Assuming table has thead
            const thead = table.querySelector('thead');
            const cols = thead.querySelectorAll('tr')[0].children;

            for (let i = 0; i < cols.length; i++) {
                const th = document.createElement('th');
                if (cols[i].classList.contains('no-filter')) {
                    th.innerHTML = '';
                } else {
                    const input = document.createElement('input');
                    input.type = 'text';
                    input.placeholder = 'Filter...';
                    input.style.width = '100%';
                    input.addEventListener('keyup', () => filterTable(table, i, input.value));
                    th.appendChild(input);
                }
                filterRow.appendChild(th);
            }
            thead.appendChild(filterRow);
        }
    });
});

function sortTable(table, colIndex, type, asc) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const modifier = asc ? 1 : -1;

    rows.sort((a, b) => {
        const aVal = a.cells[colIndex].innerText.trim();
        const bVal = b.cells[colIndex].innerText.trim();

        if (type === 'number') {
            return modifier * (parseFloat(aVal) - parseFloat(bVal));
        } else {
            return modifier * aVal.localeCompare(bVal);
        }
    });

    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

function filterTable(table, colIndex, query) {
    const tbody = table.querySelector('tbody');
    const rows = tbody.querySelectorAll('tr');
    query = query.toLowerCase();

    rows.forEach(row => {
        const cellText = row.cells[colIndex].innerText.toLowerCase();
        // Check if this row is hidden by other filters?
        // Simple approach: show if matches query, unless another filter hides it.
        // For simplicity: We only check the current filter logic here.
        // Ideally we should check all inputs.

        // Better: iterate all filter inputs to determine visibility
        let show = true;
        const filterInputs = table.querySelectorAll('.filter-row input');

        // This simple implementation might be slow for huge tables but fine here
        // We need to match the input index to the cell index.
        // We stored the filterRow inputs in order.

        // Let's re-evaluate all filters for this row
        const inputs = table.querySelectorAll('.filter-row th');

        for (let i = 0; i < inputs.length; i++) {
            const input = inputs[i].querySelector('input');
            if (input && input.value) {
                 const val = row.cells[i].innerText.toLowerCase();
                 if (!val.includes(input.value.toLowerCase())) {
                     show = false;
                     break;
                 }
            }
        }

        row.style.display = show ? '' : 'none';
    });
}
