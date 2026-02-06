<?php

namespace App\Events;

/**
 * ModelEvent
 * Sistema de eventos para models
 */
class ModelEvent
{
    protected static array $listeners = [];
    
    /**
     * Register event listener
     */
    public static function listen(string $event, callable $callback): void
    {
        if (!isset(static::$listeners[$event])) {
            static::$listeners[$event] = [];
        }
        
        static::$listeners[$event][] = $callback;
    }
    
    /**
     * Fire event
     */
    public static function fire(string $event, $model): void
    {
        if (!isset(static::$listeners[$event])) {
            return;
        }
        
        foreach (static::$listeners[$event] as $callback) {
            call_user_func($callback, $model);
        }
    }
    
    /**
     * Clear all listeners
     */
    public static function clearListeners(): void
    {
        static::$listeners = [];
    }
    
    /**
     * Get all listeners for an event
     */
    public static function getListeners(string $event): array
    {
        return static::$listeners[$event] ?? [];
    }
}
