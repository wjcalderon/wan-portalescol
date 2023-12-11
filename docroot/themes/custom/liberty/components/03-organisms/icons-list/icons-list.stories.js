/* eslint-disable */
import React from 'react';

import icons from './icons-list.twig';

import iconsData from './icons-list.yml';
import iconsItemsData from './icons-list-items.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Organisms/Icons List' };

export const iconsList = () => (
    <div dangerouslySetInnerHTML={{ __html: icons({ ...iconsData, ...iconsItemsData }) }} />
);