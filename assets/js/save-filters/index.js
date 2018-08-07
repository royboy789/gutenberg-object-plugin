import { CoreParagraph } from './core-paragraph';
import { CoreCoverImage } from './core-cover-image';
import { CoreButton } from './core-button';
import { CoreTextColumns } from './core-text-columns';
import { CoreColumns } from './core-columns';
import { CoreImage } from './core-image';
import { CoreEmbed } from './core-embed';
import { CoreHeading } from './core-heading';
import { CoreList } from './core-list';
import { CorePreformatted } from './core-preformatted';
import { CorePullquote } from './core-pullquote';
import { CoreQuote } from './core-quote';
import { CoreSubhead } from './core-subheading';
import { CoreTable } from './core-table';
import { CoreVerse } from './core-verse';
import { CoreVideo } from './core-video';

// WDS Blocks
import { WDS_CallToAction_Block } from './wdsBlocks/call-to-action';
import { WDS_Hero_Block } from "./wdsBlocks/hero";
import { WDS_TwoColumn_Block } from "./wdsBlocks/two-column";
import { WDS_RecentPosts_Block } from "./wdsBlocks/recent-posts";

export class SaveFilters {
  constructor() {
    new CoreParagraph();
    new CoreCoverImage();
    new CoreButton();
    new CoreTextColumns();
    new CoreColumns();
    new CoreImage();
    new CoreEmbed();
    new CoreHeading();
    new CoreList();
    new CorePreformatted();
    new CorePullquote();
    new CoreQuote();
    new CoreSubhead();
    new CoreTable();
    new CoreVerse();
    new CoreVideo();

    // WDS Blocks
    new WDS_CallToAction_Block();
    new WDS_Hero_Block();
    new WDS_TwoColumn_Block();
    new WDS_RecentPosts_Block();


  }
}
