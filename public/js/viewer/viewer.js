class ImageViewer {
    /**
     * Initialize the ImageViewer class
     * @constructor
     */
    constructor() {
      // Ensure ViewerJS is loaded
      if (typeof Viewer === 'undefined') {
        console.error('ViewerJS is not loaded. Please include the ViewerJS library before using this script.');
        return;
      }

      this.viewers = {};
    }

    /**
     * Create a single image viewer
     * @param {string} elementId - The ID of the image element
     * @param {Object} options - ViewerJS options
     * @return {Object} - The created viewer instance
     */
    createSingleViewer(elementId, options = {}) {
      const element = document.getElementById(elementId);

      if (!element) {
        console.error(`Element with ID "${elementId}" not found.`);
        return null;
      }

      // Default options for single image viewer
      const defaultOptions = {
        inline: false,
        viewed() {
          this.viewers[elementId].zoomTo(1);
        }
      };

      const mergedOptions = { ...defaultOptions, ...options };

      // Create and store the viewer
      this.viewers[elementId] = new Viewer(element, mergedOptions);

      return this.viewers[elementId];
    }

    /**
     * Create an inline single image viewer
     * @param {string} elementId - The ID of the image element
     * @param {Object} options - Additional ViewerJS options
     * @return {Object} - The created viewer instance
     */
    createInlineViewer(elementId, options = {}) {
      return this.createSingleViewer(elementId, {
        ...options,
        inline: true
      });
    }

    /**
     * Create a gallery viewer for multiple images
     * @param {string} containerId - The ID of the container element with images
     * @param {Object} options - ViewerJS options
     * @return {Object} - The created gallery instance
     */
    createGallery(containerId, options = {}) {
      const container = document.getElementById(containerId);

      if (!container) {
        console.error(`Container with ID "${containerId}" not found.`);
        return null;
      }

      // Create and store the gallery
      this.viewers[containerId] = new Viewer(container, options);

      return this.viewers[containerId];
    }

    /**
     * Show a specific viewer
     * @param {string} id - The ID associated with the viewer
     */
    show(id) {
      if (this.viewers[id]) {
        this.viewers[id].show();
      } else {
        console.error(`No viewer found with ID "${id}".`);
      }
    }

    /**
     * Hide a specific viewer
     * @param {string} id - The ID associated with the viewer
     */
    hide(id) {
      if (this.viewers[id]) {
        this.viewers[id].hide();
      } else {
        console.error(`No viewer found with ID "${id}".`);
      }
    }

    /**
     * Destroy a specific viewer
     * @param {string} id - The ID associated with the viewer
     */
    destroy(id) {
      if (this.viewers[id]) {
        this.viewers[id].destroy();
        delete this.viewers[id];
      } else {
        console.error(`No viewer found with ID "${id}".`);
      }
    }

    /**
     * Get a specific viewer instance
     * @param {string} id - The ID associated with the viewer
     * @return {Object|null} - The viewer instance or null if not found
     */
    getViewer(id) {
      return this.viewers[id] || null;
    }
  }

  // Create global instance
  window.imageViewer = new ImageViewer();
