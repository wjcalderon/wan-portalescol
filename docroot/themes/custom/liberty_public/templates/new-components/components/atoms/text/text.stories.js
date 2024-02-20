import text from './text-examples.twig';
// import blockquote from './text/02-blockquote.twig';
// import pre from './text/05-pre.twig';
// import paragraph from './text/03-inline-elements.twig';

// import blockquoteData from './text/blockquote.yml';
// import headingData from './headings/headings.yml';

/**
 * Storybook Definition.
 */
export default { title: 'Atoms/Text' };

// Loop over items in headingData to show each one in the example below.
export const textExamples = () => text();

// export const blockquoteExample = () => blockquote(blockquoteData);

// export const preformatted = () => pre();

// export const random = () => paragraph();
