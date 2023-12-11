/* eslint-disable */
import React from 'react';

// import card from './card.twig';
import Service from './card-service.twig';

import cardData from './card.yml';
// import cardBgData from './card-bg.yml';
import cardBlue from './card-service-blue.yml';

import './cardservice';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Cards' };

// export const cardExample = () => (
//   <div dangerouslySetInnerHTML={{ __html: card(cardData) }} />
// );
// export const cardWithBackground = () => (
//   <div dangerouslySetInnerHTML={{ __html: card({ ...cardData, ...cardBgData }) }} />
// );
export const cardService = () => (
  <div dangerouslySetInnerHTML={{ __html: Service(cardData) }} />
);

export const cardServiceBlue = () => (
  <div dangerouslySetInnerHTML={{ __html: Service({ ...cardData, ...cardBlue }) }} />
);