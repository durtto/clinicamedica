// DOM Navigation functions
// James Gregory 2006 (j.gregory@metalmadness.co.uk)
	
function getNextElement(start, identity, children)
{
	var next, first = arguments[3];
	
	next = (typeof start == 'string') ? document.getElementById(start) : start;
	if (!first) first = next;
	if (!children) children = true;

	do {
		if (!next) {
			return null;
		} else if (next != first && (!identity || isType(next, identity))) {
			return next;
		} else {
			if (children && next.hasChildNodes()) {
				var inner = getFirstChild(next, identity);
				
				if (inner) return inner;
			}
			
			if (next.nextSibling) {
				next = next.nextSibling;
			} else {
				next = getNextElement(getNextParent(next), identity, children, start);
			}
		}
	} while (next)
}

function getPreviousElement(start, identity, children)
{
	var next, first = arguments[3];
	
	next = (typeof start == 'string') ? next = document.getElementById(start) : start;
	if (!first) first = next;
	if (!children) children = true;
	
	do {
		if (!next) {
			return null;
		} else if (next != first && (!identity || isType(next, identity))) {
			return next;
		} else {
			var inner;
			
			if (children && next.hasChildNodes()) {
				inner = getLastChild(next, identity);
				
				if (inner) return inner;
			}

			if (next != first && children && next.hasChildNodes() && inner) {
				return inner;
			} else if (next.previousSibling) {
				next = next.previousSibling;
			} else if (next.parentNode != first && (!identity || isType(next.parentNode, identity))) {
				return next.parentNode;
			} else {
				var parent = next.parentNode;
				
				do {
					if (parent != first && (!identity || isType(parent, identity))) {
						return parent;
					}
					
					parent = parent.parentNode;
				} while (parent)
				next = getPreviousParent(next);
			}
		}
	} while (next)
}

function getFirstChild(el, identity) { return getChild(el, identity, 'forward'); }
function getLastChild(el, identity) { return getChild(el, identity, 'backward'); }

function getChild(el, identity, direction)
{
	if (typeof el == 'string') el = document.getElementById(el);
	
	if (!direction || direction == 'forward') {
		for (var i = 0; i < el.childNodes.length; i++) {
			if (!identity || isType(el.childNodes[i], identity)) {
				return el.childNodes[i];
			} else if (el.childNodes[i].hasChildNodes()) {
				return getChild(el.childNodes[i], identity, direction);
			}
		}
	} else if (direction == 'backward') {
		for (var i = (el.childNodes.length - 1); i > 0; i--) {
			if (!identity || isType(el.childNodes[i], identity)) {
				return el.childNodes[i];
			} else if (el.childNodes[i].hasChildNodes()) {
				return getChild(el.childNodes[i], identity, direction);
			}
		}
	}
	
	return null;
}

function isType(el, identity)
{
	if (typeof el == 'string') el = document.getElementById(el);

	if (!isNaN(identity)) {
		return (el.nodeType == identity);
	} else {
		return (el.tagName == identity.toUpperCase());
	}
}

function getNextParent(el) { return getParentAdjacent(el, 'forward'); }
function getPreviousParent(el) { return getParentAdjacent(el, 'backward'); }

function getParentAdjacent(el, direction)
{
	var next;
	
	if (!direction) direction = 'forward';
	next = (typeof el == 'string') ? document.getElementById(el).parentNode : el.parentNode;
	
	do {
		if (!next) {
			return null;
		} else if (direction == 'forward' && next.nextSibling) {
			return next.nextSibling;
		} else if (direction == 'backward' && next.previousSibling) {
			return next.previousSibling;
		} else {
			return getParentAdjacent(next, direction); 
		}
	}
	while (next)
}