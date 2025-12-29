import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// Initialize tooltips and popovers
document.addEventListener('DOMContentLoaded', function() {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Image loading with skeleton
    const productImages = document.querySelectorAll('.product-image[loading="lazy"]');
    productImages.forEach(function(img) {
        const wrapper = img.closest('.product-image-wrapper');
        const skeleton = wrapper ? wrapper.querySelector('.skeleton-loader') : null;
        
        if (skeleton) {
            skeleton.style.display = 'flex';
        }
        
        if (img.complete) {
            img.classList.add('loaded');
            if (skeleton) skeleton.style.display = 'none';
        } else {
            img.addEventListener('load', function() {
                img.classList.add('loaded');
                if (skeleton) {
                    setTimeout(function() {
                        skeleton.style.display = 'none';
                    }, 300);
                }
            });
            
            img.addEventListener('error', function() {
                if (skeleton) skeleton.style.display = 'none';
            });
        }
    });
});

