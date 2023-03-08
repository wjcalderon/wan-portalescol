/* eslint-disable */
import React from 'react';

import coverage from './coverage.twig';
import coverageModal from './coverage-modal.twig';

import coverageData from './coverage.yml';

// import './coverage';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Coverages' };

export const CoverageList = () => (
  <div dangerouslySetInnerHTML={{ __html: coverage(coverageData) }} />
);

export const CoverageModal = () => (
  <div dangerouslySetInnerHTML={{ __html: coverageModal(coverageData) }} />
);