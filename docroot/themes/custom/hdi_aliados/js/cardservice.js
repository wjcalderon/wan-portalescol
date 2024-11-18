/* eslint-disable */
for (let q = 0; q < 4; q++) {
  const card = document.getElementById('cover_' + (q + 1));

  if (card) {
    const allItem = card.querySelectorAll('.card-service__all-items');

    for (let u = 0; u < allItem.length; u++) {
      const elementAllitem = allItem[u];
      const searchActive = elementAllitem
        .closest('.card-service__content')
        .querySelectorAll('.card-service__tab.is-active');
      for (let i = 0; i < searchActive.length; i++) {
        const elementSearch = searchActive[i];
        const liCount = elementSearch.clientHeight;

        if (liCount == 320) {
          elementAllitem.classList.remove('is-hidden');
        } else {
          elementAllitem.classList.add('is-hidden');
        }
      }
    }

    let ischannel = document.getElementsByClassName('channel-attention');
    if (ischannel.length > 0) {
      let footerlogo = document.getElementById('footer');
      let cornerlogo = document.getElementById('logo-corner');
      footerlogo.classList.add('addpadding');
      cornerlogo.classList.add('addpadding');
    }

    if (ischannel.length > 300) {
      let footerlogo = document.getElementById('footer');
      let cornerlogo = document.getElementById('logo-corner');
      footerlogo.classList.add('addpaddingplus');
      cornerlogo.classList.add('addpaddingplus');
    }

    for (let b = 0; b < allItem.length; b++) {
      const element = allItem[b];
      element.addEventListener('click', function () {
        const parten = element
          .closest('.card-service__content')
          .querySelectorAll('.card-service__tab.is-active');
        for (let x = 0; x < parten.length; x++) {
          const element2 = parten[x];
          element2.style.maxHeight = 'none';
        }

        element.classList.add('is-hidden');

        const short = card.querySelectorAll('.card-service__short-items');
        for (let l = 0; l < short.length; l++) {
          const el = short[l];
          el.classList.remove('is-hidden');
        }
      });
    }

    const shortItem = card.querySelectorAll('.card-service__short-items');

    for (let w = 0; w < shortItem.length; w++) {
      const eshort = shortItem[w];
      eshort.addEventListener('click', function () {
        const parte2 = eshort
          .closest('.card-service__content')
          .querySelectorAll('.card-service__tab.is-active');
        for (let x = 0; x < parte2.length; x++) {
          const element2 = parte2[x];
          element2.style.maxHeight = '320px';
        }
        eshort.classList.add('is-hidden');

        const allit = card.querySelectorAll('.card-service__all-items');
        for (let n = 0; n < allit.length; n++) {
          const elall = allit[n];
          elall.classList.remove('is-hidden');
        }
      });
    }

    const tab = card.querySelectorAll('.card-service__tablink');

    for (let w = 0; w < tab.length; w++) {
      const element = tab[w];
      element.addEventListener('click', function () {
        const activeTab = element
          .closest('.card-service__tabs')
          .querySelectorAll('.is-active');
        for (let e = 0; e < activeTab.length; e++) {
          const elementTab = activeTab[e];
          elementTab.classList.remove('is-active');
        }

        const activeContent = element
          .closest('.card-service__content')
          .querySelectorAll('.is-active');
        for (let r = 0; r < activeContent.length; r++) {
          const elementContent = activeContent[r];
          elementContent.classList.remove('is-active');
        }

        element.classList.add('is-active');
        if (element.classList[2] == 'tab-0') {
          const card_list = element
            .closest('.card-service__content')
            .querySelectorAll('.card-service__list');
          for (let t = 0; t < card_list.length; t++) {
            const elementList = card_list[t];
            elementList.classList.add('is-active');
            elementList
                .closest('.card-service__content')
                .querySelectorAll('.card-service__all-items')[0].innerHTML =
              'Ver todos las Coberturas';
          }
        } else {
          const card_Beneficios = element
            .closest('.card-service__content')
            .querySelectorAll('.card-service__benefits');
          for (let y = 0; y < card_Beneficios.length; y++) {
            const elementBenefits = card_Beneficios[y];
            elementBenefits.classList.add('is-active');
            elementBenefits
                .closest('.card-service__content')
                .querySelectorAll('.card-service__all-items')[0].innerHTML =
              'Ver todos los Beneficios';
          }
        }

        const searchActive2 = element
          .closest('.card-service__content')
          .querySelectorAll('.card-service__tab.is-active');
        for (let i = 0; i < searchActive2.length; i++) {
          const elementSearch = searchActive2[i];
          const liCount5 = elementSearch.clientHeight;
          if (liCount5 == 320) {
            const hiddenAllItem = elementSearch
              .closest('.card-service__content')
              .querySelectorAll('.card-service__all-items');
            for (let z = 0; z < hiddenAllItem.length; z++) {
              const hiAllItem = hiddenAllItem[z];
              hiAllItem.classList.remove('is-hidden');
            }
          } else {
            const hiddenAllItem = elementSearch
              .closest('.card-service__content')
              .querySelectorAll('.card-service__all-items');
            for (let z = 0; z < hiddenAllItem.length; z++) {
              const hiAllItem = hiddenAllItem[z];
              hiAllItem.classList.add('is-hidden');
            }
            const hiddenShortItem = elementSearch
              .closest('.card-service__content')
              .querySelectorAll('.card-service__short-items');
            for (let h = 0; h < hiddenShortItem.length; h++) {
              const hiShort = hiddenShortItem[h];
              hiShort.classList.add('is-hidden');
            }
          }
          if (liCount5 > 320) {
            const sShortItem = elementSearch
              .closest('.card-service__content')
              .querySelectorAll('.card-service__short-items');
            for (let d = 0; d < sShortItem.length; d++) {
              const sShort = sShortItem[d];
              sShort.classList.remove('is-hidden');
            }
          }
        }
      });
    }
  }
}
