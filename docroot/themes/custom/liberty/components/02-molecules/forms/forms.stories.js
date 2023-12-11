/* eslint-disable */
import React from 'react';

import welcome from './form-welcome.twig';
import formbox from './form-box.twig';

import formsData from './forms.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Molecules/Forms' };

export const Welcome = () => (
  <div dangerouslySetInnerHTML={{ __html: welcome(formsData) }} />
);

export const Formbox = () => (
    <div dangerouslySetInnerHTML={{ __html: formbox(formsData) }} />
  );