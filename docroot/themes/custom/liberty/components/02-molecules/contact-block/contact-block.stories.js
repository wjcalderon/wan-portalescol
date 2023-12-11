/* eslint-disable */
import React from 'react';

import cblock from './contact-block.twig';

import cblockData from './contact-block.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Contact Block' };

export const ContactBlock2Cols = () => (
  <div dangerouslySetInnerHTML={{ __html: cblock(cblockData) }} />
);