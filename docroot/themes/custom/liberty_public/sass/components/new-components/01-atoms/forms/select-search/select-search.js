Drupal.behaviors.selectSearch = {
  attach(context) {
    const btnSelect = context.querySelector('.search-form__button');
    const selectInput = context.querySelector('.search-form__select');
    const searchBtn = context.getElementById('searchBtn');
    const searchInput = context.getElementById('searchInput');
    const opstionsSearchSelect = context.querySelectorAll(
      '.search-form__option',
    );
    const autocompleteValues = [];
    Array.from(opstionsSearchSelect).forEach((item) => {
      item.addEventListener('click', (e) => {
        const opstionValue = e.currentTarget.getAttribute('data');
        console.log(e);
        alert(opstionValue);
        selectInput.classList.remove('search-form__select--show');
      });
    });
    btnSelect.addEventListener('click', () => {
      selectInput.classList.toggle('search-form__select--show');
    });
    searchBtn.addEventListener('click', () => {
      const valueSearch = searchInput.value;
      if (valueSearch.length > 0) {
        alert(valueSearch);
        autocompleteValues.push(valueSearch);
        localStorage.setItem('autocompOptions', autocompleteValues);
      }
    });
  },
};
