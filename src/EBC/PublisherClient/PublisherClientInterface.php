<?php

/*
 * This file is a part of the Publisher client library.
 *
 * (c) 2013 Ebidtech
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace EBC\PublisherClient;

use EBC\PublisherClient\Campaign\Campaigns;

/**
 * PublisherClientInterface
 */
interface PublisherClientInterface
{
    /**
     * Choose the publisher
     *
     * @param int    $publisherId
     * @param string $key
     * @param string $secret
     *
     * @return $this
     */
    public function setPublisher($publisherId, $key, $secret);

    /**
     * @param string|null $orderBy created|updated|null
     * @param string|null $order   asc|desc|ASC|DESC|null
     *
     * @return Campaigns
     */
    public function getCampaigns($orderBy = null, $order = null);
}
