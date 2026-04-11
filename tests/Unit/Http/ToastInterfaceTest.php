<?php

namespace LibreNMS\Tests\Unit\Http;

use App\Http\Interfaces\ToastInterface;
use LibreNMS\Tests\TestCase;

final class ToastInterfaceTest extends TestCase
{
    private function assertToast(array $expected): void
    {
        $toasts = session('toasts', []);
        $last = end($toasts);

        $this->assertSame($expected['level'], $last['level']);
        $this->assertSame($expected['message'], $last['message']);
        $this->assertSame($expected['title'] ?? '', $last['title']);
        $this->assertSame($expected['options'] ?? [], $last['options']);
    }

    // --- instance calls ---

    public function testInstanceInfoTitleOnly(): void
    {
        app(ToastInterface::class)->info('Hello');

        $this->assertToast(['level' => 'info', 'message' => 'Hello', 'title' => '']);
    }

    public function testInstanceInfoWithMessage(): void
    {
        app(ToastInterface::class)->info('My Title', 'My Message');

        $this->assertToast(['level' => 'info', 'message' => 'My Message', 'title' => 'My Title']);
    }

    public function testInstanceSuccess(): void
    {
        app(ToastInterface::class)->success('Saved');

        $this->assertToast(['level' => 'success', 'message' => 'Saved']);
    }

    public function testInstanceError(): void
    {
        app(ToastInterface::class)->error('Something failed');

        $this->assertToast(['level' => 'error', 'message' => 'Something failed']);
    }

    public function testInstanceWarning(): void
    {
        app(ToastInterface::class)->warning('Watch out');

        $this->assertToast(['level' => 'warning', 'message' => 'Watch out']);
    }

    public function testInstanceWithOptions(): void
    {
        app(ToastInterface::class)->info('Title', 'Message', ['timeout' => 5000]);

        $this->assertToast(['level' => 'info', 'message' => 'Message', 'title' => 'Title', 'options' => ['timeout' => 5000]]);
    }

    // --- static calls via __callStatic ---

    public function testStaticInfoTitleOnly(): void
    {
        ToastInterface::info('Hello');

        $this->assertToast(['level' => 'info', 'message' => 'Hello', 'title' => '']);
    }

    public function testStaticInfoWithMessage(): void
    {
        ToastInterface::info('My Title', 'My Message');

        $this->assertToast(['level' => 'info', 'message' => 'My Message', 'title' => 'My Title']);
    }

    public function testStaticSuccess(): void
    {
        ToastInterface::success('Saved');

        $this->assertToast(['level' => 'success', 'message' => 'Saved']);
    }

    public function testStaticError(): void
    {
        ToastInterface::error('Something failed');

        $this->assertToast(['level' => 'error', 'message' => 'Something failed']);
    }

    public function testStaticWarning(): void
    {
        ToastInterface::warning('Watch out');

        $this->assertToast(['level' => 'warning', 'message' => 'Watch out']);
    }

    public function testStaticWithOptions(): void
    {
        ToastInterface::info('Title', 'Message', ['timeout' => 5000]);

        $this->assertToast(['level' => 'info', 'message' => 'Message', 'title' => 'Title', 'options' => ['timeout' => 5000]]);
    }

    // multiple toasts

    public function testMultipleToastsStack(): void
    {
        ToastInterface::info('First');
        ToastInterface::error('Second');

        $toasts = session('toasts', []);
        $this->assertCount(2, $toasts);
        $this->assertSame('info', $toasts[0]['level']);
        $this->assertSame('error', $toasts[1]['level']);
    }

    public function testInstanceReturnsSameInstance(): void
    {
        $toast = app(ToastInterface::class);

        $this->assertSame($toast, $toast->info('chained'));
    }

    // invalid method

    public function testInstanceThrowsOnUnknownMethod(): void
    {
        $this->expectException(\BadMethodCallException::class);

        app(ToastInterface::class)->unknown('oops');
    }

    public function testStaticThrowsOnUnknownMethod(): void
    {
        $this->expectException(\BadMethodCallException::class);

        ToastInterface::unknown('oops');
    }
}
