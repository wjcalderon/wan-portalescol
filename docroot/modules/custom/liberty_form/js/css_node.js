var el = document.getElementById('edit-moderation-state-0-state')
let default_select = el.value
const text =
  default_select == 'archived'
    ? '¿Desea desactivar esta campaña?'
    : '¿Desea activar esta campaña?'
el.addEventListener(
  'change',
  function () {
    var selectedOption = this.options[el.selectedIndex]
    const text =
      selectedOption.value == 'archived'
        ? '¿Desea desactivar esta campaña?'
        : '¿Desea activar esta campaña?'
    if (confirm(text) == true) {
      console.log('bien')
    } else {
      el.value = default_select
    }
  },
  false,
)
