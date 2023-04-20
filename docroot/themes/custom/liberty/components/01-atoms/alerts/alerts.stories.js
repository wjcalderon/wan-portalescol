/* eslint-disable */
import React from 'react';

import alert from './alerts.twig';
import alertError from './alert-error.twig';

import alertData from './alerts.yml';

/**
 * Storybook Definition.
 */
export default {title: 'Atoms/Alerts',};

// export const Alert = () => (
//   <div dangerouslySetInnerHTML={{ __html: alert(alertData) }} />
// );

export const Error = () => (
  <div dangerouslySetInnerHTML={{ __html: alertError(alertData) }} />
);