/* admin.js */

(function () {
    'use strict';

    // Ensure the script runs after the DOM is fully loaded
    document.addEventListener('DOMContentLoaded', function () {
        try {
            initSidebar();
            initThemeToggle();
            initAccordions();
            initModals();
            initToasts();
            initCarousels();
            initTooltipsAndPopovers();
            initScrollProgress();
            initClipboardCopy();
            initZoomControls();
            initFullscreenToggle();
            initLayoutShifter();
        } catch (error) {
            console.error('Error initializing admin.js:', error);
        }
    });

    /**
     * Sidebar Functionality
     */
    function initSidebar() {
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebar-overlay');
        const sidebarOpenBtn = document.getElementById('sidebar-open');
        const sidebarCloseBtn = document.getElementById('sidebar-close');

        if (!sidebar || !sidebarOverlay || !sidebarOpenBtn || !sidebarCloseBtn) {
            console.warn('Sidebar elements not found.');
            return;
        }

        // Function to open sidebar
        const openSidebar = () => {
            sidebar.classList.remove('-translate-x-full');
            sidebar.classList.add('translate-x-0');
            sidebarOverlay.classList.remove('hidden');
            sidebarOverlay.classList.add('block');
        };

        // Function to close sidebar
        const closeSidebar = () => {
            sidebar.classList.remove('translate-x-0');
            sidebar.classList.add('-translate-x-full');
            sidebarOverlay.classList.remove('block');
            sidebarOverlay.classList.add('hidden');
        };

        // Event listeners
        sidebarOpenBtn.addEventListener('click', openSidebar);
        sidebarCloseBtn.addEventListener('click', closeSidebar);
        sidebarOverlay.addEventListener('click', closeSidebar);

        // Optional: Toggle sidebar collapse on desktop
        // Implement if collapsible sidebar functionality is desired
    }

    /**
     * Theme Toggle Functionality (Dark/Light Mode)
     */
    function initThemeToggle() {
        const themeToggleBtn = document.getElementById('theme-toggle');
        if (!themeToggleBtn) {
            console.warn('Theme toggle button not found.');
            return;
        }

        // Initialize theme based on localStorage or default to light
        const savedTheme = localStorage.getItem('theme') || 'light';
        setTheme(savedTheme);

        // Event listener for theme toggle
        themeToggleBtn.addEventListener('click', () => {
            const currentTheme = document.body.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            setTheme(newTheme);
            localStorage.setItem('theme', newTheme);
        });

        function setTheme(theme) {
            document.body.setAttribute('data-theme', theme);
            const icon = theme === 'light' ? 'dark_mode' : 'light_mode';
            themeToggleBtn.querySelector('i.material-icons').textContent = icon;
        }
    }

    /**
     * Accordion Functionality
     */
    function initAccordions() {
        const accordions = document.querySelectorAll('.accordion-button');

        if (!accordions.length) {
            return;
        }

        accordions.forEach(button => {
            button.addEventListener('click', () => {
                const content = button.nextElementSibling;
                const isOpen = content.classList.contains('show');

                // Toggle the current accordion
                content.classList.toggle('show', !isOpen);
                button.classList.toggle('active', !isOpen);

                // Rotate the icon
                const icon = button.querySelector('i.material-icons');
                if (icon) {
                    icon.textContent = isOpen ? 'expand_more' : 'expand_less';
                }

                // Optionally close other accordions
                // Uncomment the following lines if only one accordion should be open at a time
                /*
                accordions.forEach(otherButton => {
                    if (otherButton !== button) {
                        otherButton.classList.remove('active');
                        otherButton.nextElementSibling.classList.remove('show');
                        const otherIcon = otherButton.querySelector('i.material-icons');
                        if (otherIcon) {
                            otherIcon.textContent = 'expand_more';
                        }
                    }
                });
                */
            });
        });
    }

    /**
     * Modal Functionality
     */
    function initModals() {
        const modals = document.querySelectorAll('.modal');

        if (!modals.length) {
            return;
        }

        modals.forEach(modal => {
            const closeButtons = modal.querySelectorAll('.modal-close, .modal .btn-close');
            const triggers = document.querySelectorAll(`[data-modal="${modal.id}"]`);

            // Open modal when trigger is clicked
            triggers.forEach(trigger => {
                trigger.addEventListener('click', () => {
                    openModal(modal);
                });
            });

            // Close modal when close button is clicked
            closeButtons.forEach(btn => {
                btn.addEventListener('click', () => {
                    closeModal(modal);
                });
            });

            // Close modal when clicking outside the modal content
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    closeModal(modal);
                }
            });
        });

        function openModal(modal) {
            modal.classList.remove('hidden');
            modal.classList.add('block');
            // Prevent background scrolling
            document.body.style.overflow = 'hidden';
        }

        function closeModal(modal) {
            modal.classList.remove('block');
            modal.classList.add('hidden');
            // Restore background scrolling
            document.body.style.overflow = '';
        }
    }

    /**
     * Toast Notifications Functionality
     */
    function initToasts() {
        const toastContainer = document.querySelector('.toast-container') || createToastContainer();

        // Function to show toast
        window.showToast = function (message, type = 'info', duration = 3000) {
            try {
                const toast = document.createElement('div');
                toast.classList.add(
                    'toast',
                    'bg-blue-800', // Default background
                    'text-white',
                    'rounded',
                    'shadow-lg',
                    'flex',
                    'justify-between',
                    'items-center',
                    'px-4',
                    'py-2',
                    'opacity-0',
                    'transform',
                    'translate-y-4',
                    'transition',
                    'duration-300'
                );

                // Set background based on type
                switch (type) {
                    case 'success':
                        toast.classList.replace('bg-blue-800', 'bg-green-500');
                        break;
                    case 'danger':
                        toast.classList.replace('bg-blue-800', 'bg-red-500');
                        break;
                    case 'warning':
                        toast.classList.replace('bg-blue-800', 'bg-yellow-500');
                        break;
                    case 'info':
                        // Default is blue
                        break;
                    case 'error':
                        toast.classList.replace('bg-blue-800', 'bg-red-600');
                        break;
                    case 'alert':
                        toast.classList.replace('bg-blue-800', 'bg-orange-500');
                        break;
                    case 'update':
                        toast.classList.replace('bg-blue-800', 'bg-purple-500');
                        break;
                    case 'notification':
                        toast.classList.replace('bg-blue-800', 'bg-teal-500');
                        break;
                    case 'hurray':
                        toast.classList.replace('bg-blue-800', 'bg-pink-500');
                        break;
                    default:
                        // If type is unknown, keep default
                        break;
                }

                toast.innerHTML = `
                    <span>${message}</span>
                    <button class="ml-4 text-white focus:outline-none">&times;</button>
                `;
                toastContainer.appendChild(toast);

                // Show the toast
                requestAnimationFrame(() => {
                    toast.classList.remove('opacity-0', 'translate-y-4');
                    toast.classList.add('opacity-100', 'translate-y-0');
                });

                // Auto-dismiss after duration
                setTimeout(() => {
                    hideToast(toast);
                }, duration);

                // Dismiss on close button click
                toast.querySelector('button').addEventListener('click', () => {
                    hideToast(toast);
                });
            } catch (error) {
                console.error('Error showing toast:', error);
            }
        };

        // Function to hide and remove toast
        function hideToast(toast) {
            toast.classList.remove('opacity-100', 'translate-y-0');
            toast.classList.add('opacity-0', 'translate-y-4');
            toast.addEventListener('transitionend', () => {
                toast.remove();
            });
        }

        // Helper to create toast container if not present
        function createToastContainer() {
            const container = document.createElement('div');
            container.classList.add(
                'toast-container',
                'fixed',
                'bottom-4',
                'right-4',
                'flex',
                'flex-col',
                'items-end',
                'space-y-2',
                'z-50'
            );
            document.body.appendChild(container);
            return container;
        }
    }

    /**
     * Carousel Functionality
     */
    function initCarousels() {
        const carousels = document.querySelectorAll('.carousel');

        if (!carousels.length) {
            return;
        }

        carousels.forEach(carousel => {
            const items = carousel.querySelectorAll('.carousel-item');
            const prevBtn = carousel.querySelector('.carousel-prev');
            const nextBtn = carousel.querySelector('.carousel-next');
            let currentIndex = 0;
            const totalItems = items.length;

            if (totalItems === 0) return;

            // Initialize first item as active
            items.forEach((item, index) => {
                if (index === 0) {
                    item.classList.add('active');
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                    item.classList.remove('active');
                }
            });

            // Show specific slide
            const showSlide = (index) => {
                if (index < 0) index = totalItems - 1;
                if (index >= totalItems) index = 0;
                items.forEach((item, idx) => {
                    if (idx === index) {
                        item.classList.remove('hidden');
                        item.classList.add('active');
                    } else {
                        item.classList.add('hidden');
                        item.classList.remove('active');
                    }
                });
                currentIndex = index;
            };

            // Next slide
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    showSlide(currentIndex + 1);
                });
            }

            // Previous slide
            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    showSlide(currentIndex - 1);
                });
            }

            // Optional: Auto-slide
            /*
            setInterval(() => {
                showSlide(currentIndex + 1);
            }, 5000); // Change slide every 5 seconds
            */
        });
    }

    /**
     * Tooltips and Popovers Functionality
     */
    function initTooltipsAndPopovers() {
        // Tooltips are handled via CSS hover, but for touch devices, add click toggling
        const tooltips = document.querySelectorAll('.tooltip');

        tooltips.forEach(tooltip => {
            tooltip.addEventListener('click', (e) => {
                e.preventDefault();
                const tooltipText = tooltip.querySelector('.tooltip-text');
                if (tooltipText) {
                    tooltipText.classList.toggle('opacity-100');
                    tooltipText.classList.toggle('visible');
                    tooltipText.classList.toggle('invisible');
                }
            });
        });

        // Popovers can be similar
        const popovers = document.querySelectorAll('.popover');

        popovers.forEach(popover => {
            const trigger = popover.querySelector('.popover-trigger');
            const content = popover.querySelector('.popover-content');

            if (trigger && content) {
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    content.classList.toggle('hidden');
                    content.classList.toggle('block');
                });

                // Close popover when clicking outside
                document.addEventListener('click', (e) => {
                    if (!popover.contains(e.target)) {
                        content.classList.add('hidden');
                        content.classList.remove('block');
                    }
                });
            }
        });
    }

    /**
     * Scroll Progress Indicator Functionality
     */
    function initScrollProgress() {
        const progressBar = document.getElementById('scroll-progress');
        if (!progressBar) {
            return;
        }

        window.addEventListener('scroll', () => {
            const scrollTop = window.scrollY;
            const docHeight = document.body.scrollHeight - window.innerHeight;
            const scrollPercent = (scrollTop / docHeight) * 100;
            progressBar.style.width = `${scrollPercent}%`;
        });
    }

    /**
     * Clipboard Copy Functionality
     */
    function initClipboardCopy() {
        const copyButtons = document.querySelectorAll('.clipboard-copy');

        if (!copyButtons.length) {
            return;
        }

        copyButtons.forEach(button => {
            button.addEventListener('click', () => {
                const textToCopy = button.getAttribute('data-clipboard-text');
                if (!textToCopy) {
                    console.warn('No data-clipboard-text attribute found.');
                    return;
                }
                copyText(textToCopy).then(() => {
                    window.showToast('Copied to clipboard!', 'success', 2000);
                }).catch(err => {
                    console.error('Failed to copy text:', err);
                    window.showToast('Failed to copy!', 'danger', 2000);
                });
            });
        });

        async function copyText(text) {
            if (!navigator.clipboard) {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = text;
                textarea.style.position = 'fixed'; // Prevent scrolling to bottom
                textarea.style.opacity = '0';
                document.body.appendChild(textarea);
                textarea.focus();
                textarea.select();
                return new Promise((resolve, reject) => {
                    try {
                        document.execCommand('copy') ? resolve() : reject();
                        textarea.remove();
                    } catch (err) {
                        reject(err);
                    }
                });
            }
            return navigator.clipboard.writeText(text);
        }
    }

    /**
     * Zoom Controls Functionality
     */
    function initZoomControls() {
        const zoomInBtn = document.querySelector('.zoom-controls .btn-zoom-in');
        const zoomOutBtn = document.querySelector('.zoom-controls .btn-zoom-out');

        if (!zoomInBtn || !zoomOutBtn) {
            return;
        }

        let zoomLevel = 1;

        zoomInBtn.addEventListener('click', () => {
            zoomLevel += 0.1;
            zoomLevel = Math.min(zoomLevel, 3); // Max zoom level
            document.body.style.transform = `scale(${zoomLevel})`;
            document.body.style.transformOrigin = '0 0';
        });

        zoomOutBtn.addEventListener('click', () => {
            zoomLevel = Math.max(zoomLevel - 0.1, 0.5); // Min zoom level
            document.body.style.transform = `scale(${zoomLevel})`;
            document.body.style.transformOrigin = '0 0';
        });
    }

    /**
     * Fullscreen Toggle Functionality
     */
    function initFullscreenToggle() {
        const fullscreenBtn = document.querySelector('.fullscreen-toggle');

        if (!fullscreenBtn) {
            return;
        }

        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                document.documentElement.requestFullscreen().catch(err => {
                    console.error(`Error attempting to enable full-screen mode: ${err.message}`);
                    window.showToast('Failed to enter fullscreen mode.', 'danger', 2000);
                });
            } else {
                document.exitFullscreen();
            }
        });

        // Update icon based on fullscreen state
        document.addEventListener('fullscreenchange', () => {
            if (document.fullscreenElement) {
                fullscreenBtn.querySelector('i.material-icons').textContent = 'fullscreen_exit';
            } else {
                fullscreenBtn.querySelector('i.material-icons').textContent = 'fullscreen';
            }
        });
    }

    /**
     * Layout Shifter Functionality
     */
    function initLayoutShifter() {
        const layoutButtons = document.querySelectorAll('.layout-shifter button');

        if (!layoutButtons.length) {
            return;
        }

        layoutButtons.forEach(button => {
            button.addEventListener('click', () => {
                const layout = button.getAttribute('data-layout');
                shiftLayout(layout);
            });
        });
    }

    /**
     * Shift Layout Function
     * @param {string} layout - The layout to switch to
     */
    function shiftLayout(layout) {
        const body = document.body;
        // Example layouts: grid, list, etc.
        body.classList.remove('layout-grid', 'layout-list'); // Remove existing layout classes
        body.classList.add(`layout-${layout}`);
        // Implement specific layout changes as needed
    }

})();
