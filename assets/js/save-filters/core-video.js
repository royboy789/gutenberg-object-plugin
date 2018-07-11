import { CleanFilter } from './CleanFilter';

export class CoreVideo extends CleanFilter {

  constructor() {
    super( 'core-video' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.caption = wp.element.renderToString( attributes.caption );
    return attributes;
  }

}