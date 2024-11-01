import checkbox from './checkbox/checkbox.twig';
import radio from './radio/radio.twig';
import select from './select/select.twig';
import input from './input/input.twig';
import switchToggle from './switch/switch.twig';
import textfields from './itemform/itemform.twig';
import selectSearchTwig from './select-search/select-search.twig';

import checkboxData from './checkbox/checkbox.yml';
import radioData from './radio/radio.yml';
import selectOptionsData from './select/select.yml';
import inputData from './input/input.yml';
import itemform from './itemform/itemform.yml';
import selectSearchData from './select-search/select-search.yml';
import './select-search/select-search';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/Forms' };

export const checkboxes = () => checkbox(checkboxData);

export const radioButtons = () => radio(radioData);

export const selectDropdowns = () => select(selectOptionsData);

export const switchButton = () => switchToggle();

export const textfieldsExamples = () => textfields(itemform);

export const inputs = () => input(inputData);

export const selectSearch = () => selectSearchTwig(selectSearchData);
