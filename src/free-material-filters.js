export function enhanceFreeMaterialFilters(root = document) {
  const filterRoots = root.querySelectorAll("[data-free-material-filters]");

  filterRoots.forEach((filterRoot) => {
    const form = filterRoot.querySelector("[data-free-material-filter-form]");
    const checkboxes = [...filterRoot.querySelectorAll("[data-free-material-filter]")];
    const cards = [...filterRoot.querySelectorAll("[data-free-material-card]")];
    const emptyState = filterRoot.querySelector("[data-free-material-empty]");
    const clearButton = filterRoot.querySelector("[data-free-material-clear]");

    if (!form || !checkboxes.length || !cards.length) {
      return;
    }

    const getSelectedCategories = () =>
      checkboxes.filter((checkbox) => checkbox.checked).map((checkbox) => checkbox.value);

    const updateUrl = (selectedCategories) => {
      const url = new URL(window.location.href);

      if (selectedCategories.length) {
        url.searchParams.set("material_categories", selectedCategories.join(","));
      } else {
        url.searchParams.delete("material_categories");
      }

      window.history.replaceState({}, "", url);
    };

    const applyFilters = () => {
      const selectedCategories = getSelectedCategories();
      let visibleCount = 0;

      cards.forEach((card) => {
        const cardCategories = (card.dataset.categories || "").split(" ").filter(Boolean);
        const shouldShow =
          !selectedCategories.length ||
          selectedCategories.some((category) => cardCategories.includes(category));

        card.hidden = !shouldShow;

        if (shouldShow) {
          visibleCount += 1;
        }
      });

      if (emptyState) {
        emptyState.hidden = visibleCount > 0;
      }

      updateUrl(selectedCategories);
    };

    const restoreFiltersFromUrl = () => {
      const params = new URLSearchParams(window.location.search);
      const selectedCategories = (params.get("material_categories") || "")
        .split(",")
        .map((category) => category.trim())
        .filter(Boolean);

      checkboxes.forEach((checkbox) => {
        checkbox.checked = selectedCategories.includes(checkbox.value);
      });
    };

    form.addEventListener("submit", (event) => {
      event.preventDefault();
      applyFilters();
    });

    checkboxes.forEach((checkbox) => {
      checkbox.addEventListener("change", applyFilters);
    });

    if (clearButton) {
      clearButton.addEventListener("click", () => {
        checkboxes.forEach((checkbox) => {
          checkbox.checked = false;
        });
        applyFilters();
      });
    }

    restoreFiltersFromUrl();
    applyFilters();
  });
}
