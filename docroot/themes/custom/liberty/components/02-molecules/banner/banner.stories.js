/* eslint-disable */
import React from 'react';

import banner from './banner.twig';

import bannerData from './banner.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Banner' };

export const BannerLanding = () => (
  <div dangerouslySetInnerHTML={{ __html: banner(bannerData) }} />
);
