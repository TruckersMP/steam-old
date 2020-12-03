<?php

namespace Syntax\SteamApi\Steam;

use Syntax\SteamApi\Client;
use NukaCode\Database\Collection;
use Syntax\SteamApi\Containers\Item as ItemContainer;
use Syntax\SteamApi\Exceptions\ApiCallFailedException;
use Syntax\SteamApi\Inventory;

class Item extends Client
{
    public function __construct()
    {
        parent::__construct();
        $this->url       = \Config::get('steam-api.steamApiKey');
        $this->isService = true;
        $this->interface = 'api';
    }

    public function GetPlayerItems($appId, $steamId)
    {
        // Set up the api details
        $this->url       = \Config::get('steam-api.steamApiKey');
        $this->interface = 'IEconItems_' . $appId;
        $this->method    = __FUNCTION__;
        $this->version   = 'v0001';

        $arguments = ['steamId' => $steamId];

        try {
            // Get the client
            $client = $this->setUpClient($arguments);
        } catch (ApiCallFailedException $exception) {
            // No items exist for this game.
            return null;
        }

        // Clean up the items
        $items = $this->convertToObjects($client->result->items);

        // Return a full inventory
        return new Inventory($client->result->num_backpack_slots, $items);
    }

    protected function convertToObjects($items)
    {
        return $this->convertItems($items);
    }

    /**
     * @param array $items
     *
     * @return Collection
     */
    protected function convertItems($items)
    {
        $convertedItems = new Collection();

        foreach ($items as $item) {
            $convertedItems->add(new ItemContainer($item));
        }

        return $convertedItems;
    }
}
