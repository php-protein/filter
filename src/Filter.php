<?php declare(strict_types=1);

/**
 * Filter
 *
 * Global filters handler.
 *
 * @package Proteins
 * @author  "Stefano Azzolini"  <lastguest@gmail.com>
 */

namespace Proteins;

abstract class Filter {
    use Filters {
          filter       as add;
          filterSingle as single;
          filterRemove as remove;
          filterWith   as with;
    }
}
