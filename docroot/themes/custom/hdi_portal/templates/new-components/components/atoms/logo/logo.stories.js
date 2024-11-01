// Splash Stories
import logoComp from './logo-examples.twig';

import logoData from './logo.yml';
/**
 * Storybook Definition.
 */
export default { title: 'Atoms/logo' };

export const logo = () => logoComp(logoData);
