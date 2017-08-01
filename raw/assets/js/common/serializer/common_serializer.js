/**
 * This <server-gardu-reporter> project created by :
 * Name         : syafiq
 * Date / Time  : 01 August 2017, 8:54 PM.
 * Email        : syafiq.rezpector@gmail.com
 * Github       : syafiqq
 */


/**
 * This code Generally from https://github.com/macek/jquery-serialize-object/issues/80 with babel conversion
 * Babel...
 * */

"use strict";

function _defineProperty(obj, key, value)
{
    if (key in obj)
    {
        Object.defineProperty(obj, key, {value: value, enumerable: true, configurable: true, writable: true});
    } else
    {
        obj[key] = value;
    }
    return obj;
}

var type = function type(x) {
    if (x === undefined)
    {
        return undefined;
    }
    if (x === null)
    {
        return null;
    }
    return x.constructor;
};

// define which values are to be considered "empty"
var isEmpty = function isEmpty(x) {
    switch (type(x))
    {
        case undefined:
            return true;
        case null:
            return true;
        case Object:
            return isEmpty(Object.keys(x));
        case Array:
            return x.length === 0;
        case String:
            return x.length === 0;
    }
};

// removeEmptyValues(obj) - deeply remove all "empty" values
var removeEmptyValues = function removeEmptyValues(x) {
    return Object.keys(x).reduce(function (y, k) {
        if (isEmpty(x[k]))
        {
            return y;
        }
        if (type(x[k]) === Object)
        {
            return Object.assign(y, _defineProperty({}, k, removeEmptyValues(x[k])));
        }
        return Object.assign(y, _defineProperty({}, k, x[k]));
    }, {});
};

/**
 * End of code
 * */
