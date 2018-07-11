import { CleanFilter } from './CleanFilter';

export class CoreTextColumns extends CleanFilter {

  constructor() {
    super( 'core-text-columns' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.content[0] = attributes.content[0].children.length ? wp.element.renderToString( attributes.content[0].children ) : attributes.content[0];
    attributes.content[1] = attributes.content[1].children.length ? wp.element.renderToString( attributes.content[1].children ) : attributes.content[1];
    return attributes;
  }

}