let el = document.getElementById("edit-moderation-state-0-state");
let default_select = el.value;
const text =
  default_select == "archived"
    ? "¿Desea desactilet esta campaña?"
    : "¿Desea actilet esta campaña?";
el.addEventListener(
  "change",
  function () {
    let selectedOption = this.options[el.selectedIndex];
    const text =
      selectedOption.value == "archived"
        ? "¿Desea desactilet esta campaña?"
        : "¿Desea actilet esta campaña?";
    if (confirm(text) == true) {
      console.log("bien");
    } else {
      el.value = default_select;
    }
  },
  false
);
