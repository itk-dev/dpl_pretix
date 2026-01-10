# Event undo

Some things that [Event] does does not play well with managing events in pretix, and therefore this module undoes some
things that Event does.

## What is done

The module removes any special treatment of *instances of event series having only a single event instance*, i.e. for
said events it removes

1. the redirect from "edit instance" to "edit event series"
2. the access check that denies access to the "edit instances route"

[Event]: (https://github.com/danskernesdigitalebibliotek/dpl-cms/tree/develop/web/modules/custom/dpl_event)
