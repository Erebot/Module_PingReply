<?php
/*
    This file is part of Erebot.

    Erebot is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Erebot is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Erebot.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace Erebot\Module;

/**
 * \brief
 *      A basic module that sends replies to PING queries it receives.
 *
 * \note
 *      This module is required for the bot to run correctly
 *      (without being disconnected every few minutes with a
 *      "Ping timeout" quit message).
 */
class PingReply extends \Erebot\Module\Base implements \Erebot\Interfaces\HelpEnabled
{
    /**
     * This method is called whenever the module is (re)loaded.
     *
     * \param int $flags
     *      A bitwise OR of the Erebot_Module_Base::RELOAD_*
     *      constants. Your method should take proper actions
     *      depending on the value of those flags.
     *
     * \note
     *      See the documentation on individual RELOAD_*
     *      constants for a list of possible values.
     */
    public function reload($flags)
    {
        if ($flags & self::RELOAD_HANDLERS) {
            $handler = new \Erebot\EventHandler(
                array($this, 'handlePing'),
                new \Erebot\Event\Match\Type('\\Erebot\\Interfaces\\Event\\Ping')
            );
            $this->connection->addEventHandler($handler);
        }
    }

    public function getHelp(
        \Erebot\Interfaces\Event\Base\TextMessage $event,
        \Erebot\Interfaces\TextWrapper $words
    ) {
        if ($event instanceof \Erebot\Interfaces\Event\Base\PrivateMessage) {
            $target = $event->getSource();
            $chan   = null;
        } else {
            $target = $chan = $event->getChan();
        }

        if (count($words) == 1 && $words[0] === get_called_class()) {
            $msg = $this->getFormatter($chan)->_(
                "This module does not provide any command but replies ".
                "to a server's PING message with the appropriate PONG ".
                "response."
            );
            $this->sendMessage($target, $msg);
            return true;
        }
    }

    /**
     * Responds to PING requests.
     *
     * \param Erebot::Interfaces::EventHandler $handler
     *      Handler that triggered this event.
     *
     * \param Erebot::Interfaces::Event::Ping $event
     *      PING request to respond to.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function handlePing(
        \Erebot\Interfaces\EventHandler $handler,
        \Erebot\Interfaces\Event\Ping $event
    ) {
        $this->sendCommand('PONG :'.$event->getText());
    }
}
