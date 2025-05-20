document.addEventListener('DOMContentLoaded', function() {
    // Toggle sort dropdown
    const sortBtn = document.querySelector('.sort-btn');
    const sortOptions = document.querySelector('.sort-options');
    
    if (sortBtn && sortOptions) {
        sortBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sortOptions.style.display = sortOptions.style.display === 'block' ? 'none' : 'block';
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            sortOptions.style.display = 'none';
        });
    }
    
    // Preserve search query when paginating
    const searchInput = document.getElementById('searchInput');
    const paginationLinks = document.querySelectorAll('.pagination a');
    
    if (searchInput && paginationLinks.length) {
        paginationLinks.forEach(link => {
            const url = new URL(link.href);
            if (searchInput.value) {
                url.searchParams.set('search', searchInput.value);
                link.href = url.toString();
            }
        });
    }
});