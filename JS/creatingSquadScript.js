document.addEventListener("DOMContentLoaded", function () {
  setTimeout(() => {
    document.querySelector(".introScreen").style.display = "none";
    document.querySelector(".pageContent").classList.add("showContent");
  }, 500); // Matches animation duration
});

document.addEventListener("DOMContentLoaded", function () {
  let selectedCircle = null; // Store the currently clicked circle

  // Open modal when a hero circle is clicked
  document.querySelectorAll(".hero-circle").forEach((circle) => {
    circle.addEventListener("click", function () {
      selectedCircle = this; // Store reference to the clicked circle
      const heroIndex = this.getAttribute("data-hero-index");
      // Store the index in a data attribute for later use
      this.dataset.heroIndex = heroIndex;
    });
  });

  // Select hero and update the circle
  document.querySelectorAll(".hero-icon").forEach((hero) => {
    hero.addEventListener("click", function () {
      if (selectedCircle) {
        // Set selected hero inside the clicked circle
        selectedCircle.innerHTML = ""; // Clear previous selection
        let img = document.createElement("img");
        img.src = this.src;
        img.style.width = "100%";
        img.style.height = "100%";
        img.style.borderRadius = "50%";
        img.style.objectFit = "cover";
        selectedCircle.appendChild(img);

        const index = Array.from(selectedCircle.parentElement.children).indexOf(
          selectedCircle
        );

        // Extract hero name from the image path
        const heroPath = this.src;
        const heroName = this.dataset.heroName; // Get from data attribute
        const heroInput = document.getElementById(`hero${selectedCircle.dataset.heroIndex}Input`);
        heroInput.value = heroName;
        
        // Update UI
        selectedCircle.style.backgroundImage = `url('${this.src}')`;

        // Close the modal
        let heroModalElement = document.getElementById("heroModal");
        let heroModal = bootstrap.Modal.getInstance(heroModalElement);
        heroModal.hide();
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const heroModal = document.getElementById("heroModal");
  const addPlayerModal = new bootstrap.Modal(
    document.getElementById("addPlayerModal")
  );

  heroModal.addEventListener("hidden.bs.modal", function () {
    addPlayerModal.show();
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const addPlayerModal = document.getElementById("addPlayerModal");
  const heroModal = document.getElementById("heroModal");
  const savePlayerButton = document.querySelector(
    ".modal-footer .modalButtons"
  );

  // Close Add Player Modal when clicking outside (but NOT when Hero Modal is open)
  addPlayerModal.addEventListener("click", function (event) {
    if (
      event.target === addPlayerModal &&
      !heroModal.classList.contains("show")
    ) {
      closeAddPlayerModal();
    }
  });

  // Close Add Player Modal when clicking "Save Player"
  savePlayerButton.addEventListener("click", function () {
    closeAddPlayerModal();
  });

  function closeAddPlayerModal() {
    const modalInstance = bootstrap.Modal.getInstance(addPlayerModal);
    if (modalInstance) {
      modalInstance.hide();
    }
    // Remove any existing backdrops
    const backdrops = document.querySelectorAll(".modal-backdrop");
    backdrops.forEach((backdrop) => backdrop.remove());
    // Reset body classes
    document.body.classList.remove("modal-open");
    document.body.style.paddingRight = ""; // Bootstrap adds padding when backdrop exists
  }

  // Fix scrolling issue: Disable body scroll when ANY modal is open
  document.addEventListener("shown.bs.modal", function () {
    document.body.style.overflow = "hidden";
  });

  // Re-enable scrolling when ALL modals are closed
  document.addEventListener("hidden.bs.modal", function () {
    if (!document.querySelector(".modal.show")) {
      document.body.style.overflow = "auto";
    }
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const fileInput = document.getElementById("fileInput");
  const chooseFileBtn = document.getElementById("chooseFileBtn");
  const fileNameDisplay = document.getElementById("fileName");
  const verifyBtn = document.getElementById("verifyBtn");

  // Custom file upload button behavior
  chooseFileBtn.addEventListener("click", function () {
    fileInput.click();
  });

  fileInput.addEventListener("change", function () {
    fileNameDisplay.textContent =
      fileInput.files.length > 0 ? fileInput.files[0].name : "No file chosen";
  });
});
