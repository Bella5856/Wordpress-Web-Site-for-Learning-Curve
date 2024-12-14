document.addEventListener("DOMContentLoaded", function () {
  const filters = document.querySelectorAll(".filter-checkbox");
  const posts = document.querySelectorAll(".post-item");

  filters.forEach((filter) => {
    filter.addEventListener("change", function () {
      const selectedCategories = Array.from(filters)
        .filter((f) => f.dataset.type === "category" && f.checked)
        .map((f) => f.value);
      const selectedTags = Array.from(filters)
        .filter((f) => f.dataset.type === "tag" && f.checked)
        .map((f) => f.value);

      posts.forEach((post) => {
        const postCategories = post.dataset.categories.split(",");
        const postTags = post.dataset.tags.split(",");

        const matchesCategory =
          selectedCategories.length === 0 ||
          selectedCategories.some((cat) => postCategories.includes(cat));
        const matchesTag =
          selectedTags.length === 0 ||
          selectedTags.some((tag) => postTags.includes(tag));

        if (matchesCategory && matchesTag) {
          post.style.display = "";
        } else {
          post.style.display = "none";
        }
      });
    });
  });
});
