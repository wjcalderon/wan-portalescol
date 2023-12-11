/* eslint-disable */
import React from 'react';

import listicon from './list-icon.twig';

import listiconData from './list-icon.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/List Icon' };

export const ListIcon = () => (
  <div dangerouslySetInnerHTML={{ __html: listicon(listiconData) }} />
);