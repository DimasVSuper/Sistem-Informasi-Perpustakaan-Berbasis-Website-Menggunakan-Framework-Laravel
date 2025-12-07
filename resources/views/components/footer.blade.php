<div class="container">
    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1" aria-label="Bootstrap">
                <svg class="bi" width="30" height="24" aria-hidden="true">
                    <path d="M2 3.5A2.5 2.5 0 0 1 4.5 1h9A2.5 2.5 0 0 1 16 3.5v11a.5.5 0 0 1-.757.429L12 13.101l-3.243 1.828A.5.5 0 0 1 8 14.5v-11A1.5 1.5 0 0 0 6.5 2h-2A1.5 1.5 0 0 0 3 3.5v11a.5.5 0 0 1-.757.429L0 13.101V3.5z"/>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© <span id="year"></span> Company, Inc</span>
        </div>
    </footer>
</div>
<script>
    document.getElementById('year').textContent = new Date().getFullYear();
</script>