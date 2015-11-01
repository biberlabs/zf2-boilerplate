<?php
/**
 * Elasticsearch Paginator Adapter
 *
 * @since     Nov 2015
 * @author    Haydar KULEKCI <haydarkulekci@gmail.com>
 */
namespace Search\Paginator\Adapter;

use Zend\Paginator\Adapter\ArrayAdapter;

class ElasticsearchAdapter extends ArrayAdapter
{
    protected $meta = [];

    /**
     * Constructor.
     *
     * @param array $array ArrayAdapter to paginate
     */
    public function __construct(array $array = array(), $count=0)
    {
        $this->array = $array;
        $this->count = $count;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  int $offset Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        return $this->array;
    }

    public function getMeta($key)
    {
        if (isset($this->meta[$key])) {
            return $this->meta[$key];
        }

        return null;
    }

    public function setMeta($key, $value)
    {
        $this->meta[$key] = $value;
    }
}
