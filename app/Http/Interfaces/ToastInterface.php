<?php

/**
 * ToastInterface.php
 *
 * -Description-
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @link       https://www.librenms.org
 *
 * @copyright  2024 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace App\Http\Interfaces;

use Illuminate\Session\SessionManager;

class ToastInterface
{
    private const LEVELS = ['info', 'success', 'warning', 'error'];

    public function __construct(
        private readonly SessionManager $session
    ) {
    }

    public static function __callStatic(string $name, array $arguments): static
    {
        return app(self::class)->$name(...$arguments);
    }

    public function __call(string $name, array $arguments): static
    {
        if (in_array($name, self::LEVELS)) {
            return $this->message($name, ...$arguments);
        }
        throw new \BadMethodCallException("Method {$name} does not exist.");
    }

    private function message(string $level, string $title, ?string $message = null, ?array $options = null): static
    {
        $notifications = $this->session->get('toasts', []);
        array_push($notifications, [
            'level' => $level,
            'title' => $message === null ? '' : $title,
            'message' => $message ?? $title,
            'options' => $options ?? [],
        ]);
        $this->session->flash('toasts', $notifications);

        return $this;
    }
}
