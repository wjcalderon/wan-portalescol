/* eslint-disable */
import React from 'react';

import lcorner from './logo-corner.twig';

import lcornerData from './logo-corner.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Logo Corner' };


export const logoCorner = () => (
  <div dangerouslySetInnerHTML={{ __html: lcorner(lcornerData) }} />
);
