import { CleanFilter } from './../CleanFilter';

export class WDS_RecentPosts_Block extends CleanFilter {

  constructor() {
    super( 'wds-recent-posts' );
  }

  hookCallback( attributes, name, innerBlocks ) {
    attributes.taxonomies = JSON.parse( attributes.taxonomies );
    return attributes;
  }

}