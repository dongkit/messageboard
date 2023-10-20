<style>
/* Footer Styles */
footer {
    background: #333; /* Background color for the footer */
    color: #fff; /* Text color for the footer */
    padding: 20px 0; /* Add space around footer content */
    position: absolute; /* Position the footer absolutely */
    bottom: 0; /* Place the footer at the bottom */
    width: 100%; /* Full width of the viewport */
    text-align: center; /* Center align text */
}

/* Add responsiveness for smaller screens */
@media (max-width: 768px) {
    footer {
        font-size: 14px; /* Adjust font size for smaller screens */
    }
}
</style>

<footer>
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="col-m-6">
                <p>&copy; <?= date('Y'); ?> FDC | Christian Kit Tumagan</p>
                <p>
                <span></span> All rights reserved!</p>
            </div>


        </div>
    </div>
</footer>