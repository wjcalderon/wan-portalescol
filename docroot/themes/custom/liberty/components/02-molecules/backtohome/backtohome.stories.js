/* eslint-disable */
import React from 'react';

import backtohome from './backtohome.twig';

import backtohomeData from './backtohome.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/BackToHome' };


export const BackToHome = () => (
  <div dangerouslySetInnerHTML={{ __html: backtohome(backtohomeData) }} />
);

