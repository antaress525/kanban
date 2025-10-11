export default {
  mounted(el, binding) {
    el.clickOutsideEvent = (event) => {
      if (!(el === event.target || el.contains(event.target))) {
        // Appelle la fonction passée dans la directive
        binding.value(event)
      }
    }

    // Ajout de l’écouteur global
    document.addEventListener('click', el.clickOutsideEvent)
  },

  unmounted(el) {
    // Nettoyage propre de l’écouteur quand le composant est détruit
    document.removeEventListener('click', el.clickOutsideEvent)
  }
}
