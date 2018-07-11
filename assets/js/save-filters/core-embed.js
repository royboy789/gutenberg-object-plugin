import { CleanFilter } from './CleanFilter';

export class CoreEmbed extends CleanFilter {

  constructor() {
    super( 'core-embed' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.caption = wp.element.renderToString( attributes.caption );
    return attributes;
  }

}