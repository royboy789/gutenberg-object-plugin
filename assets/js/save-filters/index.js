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
  }
}
