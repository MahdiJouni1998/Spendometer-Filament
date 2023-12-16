<?php

namespace App\Providers;

use App\Models\Balance;
use App\Models\Currency;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Observers\CreateForUserObserver;
use App\Models\Iou;
use App\Models\Wallet;
use App\Models\Income;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\IncomeSource;
use App\Models\WalletsTransaction;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        Iou::class => [CreateForUserObserver::class],
        Income::class => [CreateForUserObserver::class],
        Wallet::class => [CreateForUserObserver::class],
        Balance::class => [CreateForUserObserver::class],
        Category::class => [CreateForUserObserver::class],
        Currency::class => [CreateForUserObserver::class],
        Transaction::class => [CreateForUserObserver::class],
        IncomeSource::class => [CreateForUserObserver::class],
        WalletsTransaction::class => [CreateForUserObserver::class],
    ];
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
