/**
 *
 * -----------------------------------------------------------
 *
 * CodexShaper Framework
 * A complete framework for WordPress
 *
 * -----------------------------------------------------------
 *
 */
(function ($, window, document, undefined) {
  "use strict";

  function uid(prefix) {
    return (prefix || "") + Math.random().toString(36).substr(2, 9);
  }

  // Quote regular expression characters
  //
  function preg_quote(str) {
    return (str + "").replace(/(\[|\])/g, "\\$1");
  }

  function name_nested_replace($selector, field_id) {
    var checks = [];
    var regex = new RegExp(preg_quote(field_id + "[\\d+]"), "g");

    $selector.find(":radio").each(function () {
      if (this.checked || this.orginal_checked) {
        this.orginal_checked = true;
      }
    });

    $selector.each(function (index) {
      $(this)
        .find(":input")
        .each(function () {
          this.name = this.name.replace(regex, field_id + "[" + index + "]");
          if (this.orginal_checked) {
            this.checked = true;
          }
        });
    });
  }

  $.fn.cxfDependsOn = function (options) {
    const settings = $.extend(
      {
        // Default settings
        attribute: "data-depends",
        conditionAttribute: "data-condition",
        valueAttribute: "data-value",
        groupAttribute: "data-group",
        actionsAttribute: "data-actions",
        triggerInitial: true,
        onEnable: null,
        onDisable: null,
        debug: false,
      },
      options
    );

    // Store element rules
    const rules = new Map();

    // Helper function to log debug messages
    const debug = (message) => {
      if (settings.debug) {
      }
    };

    // Parse dependency string into rules
    const parseRules = (dependencyStr) => {
      if (!dependencyStr) return [];

      return dependencyStr.split("|").map((rule) => {
        const [selector, condition, value] = rule
          .trim()
          .split(":")
          .map((part) => part.trim());
        return { selector, condition, value };
      });
    };

    // Parse actions string into array
    const parseActions = (actionsStr) => {
      if (!actionsStr) return ["show"];
      return actionsStr.split(",").map((action) => action.trim());
    };

    // Evaluate conditions
    const evaluateCondition = (element, condition, expectedValue) => {
      const $element = $(element);
      const actualValue = $element.is(":checkbox, :radio")
        ? $element.prop("checked")
        : $element.val();

      switch (condition) {
        case "equals":
        case "==":
        case "===":
          return actualValue === expectedValue;
        case "notEquals":
        case "!=":
        case "!==":
          return actualValue !== expectedValue;
        case "contains":
          return actualValue?.includes(expectedValue);
        case "empty":
          return !actualValue || actualValue.length === 0;
        case "notEmpty":
          return actualValue && actualValue.length > 0;
        case "checked":
          return $element.prop("checked");
        case "unchecked":
          return !$element.prop("checked");
        case "greaterThan":
        case ">":
          return parseFloat(actualValue) > parseFloat(expectedValue);
        case "greaterThanOrEqual":
        case ">=":
          return parseFloat(actualValue) >= parseFloat(expectedValue);
        case "lessThan":
        case "<":
          return parseFloat(actualValue) < parseFloat(expectedValue);
        case "lessThanOrEqual":
        case "<=":
          return parseFloat(actualValue) <= parseFloat(expectedValue);
        case "matches":
          return new RegExp(expectedValue).test(actualValue);
        default:
          debug(`Unknown condition: ${condition}`);
          return false;
      }
    };

    // Apply actions based on conditions
    const applyActions = ($element, satisfied, actions) => {
      actions.forEach((action) => {
        switch (action) {
          case "show":
            $element[satisfied ? "show" : "hide"]();
            break;
          case "hide":
            $element[satisfied ? "hide" : "show"]();
            break;
          case "enable":
            $element.prop("disabled", !satisfied);
            break;
          case "disable":
            $element.prop("disabled", satisfied);
            break;
          case "addClass":
            $element.toggleClass("dependent-active", satisfied);
            break;
          case "removeClass":
            $element.toggleClass("dependent-active", !satisfied);
            break;
          default:
            debug(`Unknown action: ${action}`);
        }
      });

      // Trigger callbacks
      if (satisfied && typeof settings.onEnable === "function") {
        settings.onEnable.call($element[0]);
      } else if (!satisfied && typeof settings.onDisable === "function") {
        settings.onDisable.call($element[0]);
      }
    };

    // Handle group dependencies
    const handleGroups = ($element, satisfied) => {
      const group = $element.attr(settings.groupAttribute);
      if (group) {
        $(`[${settings.groupAttribute}="${group}"]`)
          .not($element)
          .toggleClass("group-active", satisfied);
      }
    };

    // Evaluate all dependencies for an element
    const evaluateDependencies = ($target) => {
      debug(`Evaluating dependencies for ${$target.attr("id") || "element"}`);

      console.log($target.attr("data-depend-id"));

      rules.forEach((dependentElements, ruleSet) => {
        dependentElements.forEach(({ $element, rules, actions }) => {
          const results = rules.map((rule) => {
            const $ruleTarget = $(rule.selector);
            return evaluateCondition(
              $ruleTarget[0],
              rule.condition,
              rule.value
            );
          });

          // All conditions must be true
          const satisfied = results.every((result) => result);
          applyActions($element, satisfied, actions);
          handleGroups($element, satisfied);
        });
      });
    };

    // Initialize plugin for each element
    return this.each(function () {
      const $element = $(this);
      const dependencyStr = $element.attr(settings.attribute);

      console.log(dependencyStr);

      if (!dependencyStr) {
        debug("No dependencies found");
        return;
      }

      const parsedRules = parseRules(dependencyStr);

      console.log(parsedRules);
      const actions = parseActions($element.attr(settings.actionsAttribute));
      console.log(actions);

      // Store rules
      parsedRules.forEach((rule) => {
        if (!rules.has(rule.selector)) {
          rules.set(rule.selector, []);
        }
        rules.get(rule.selector).push({
          $element,
          rules: parsedRules,
          actions,
        });

        // Attach event handlers
        $(rule.selector).on("change input", function () {
          evaluateDependencies($(this));
        });
      });

      // Initial evaluation
      if (settings.triggerInitial) {
        evaluateDependencies($element);
      }
    });
  };

  //
  // Field: upload
  //
  $.fn.cxfBuilderFileUpload = function (options) {
    const settings = $.extend(
      {
        library: [], // Allowed file types (e.g., ['image', 'video'])
        onFileSelect: null, // Callback for file selection
        onFileRemove: null, // Callback for file removal
      },
      options
    );

    return this.each(function () {
      const $container = $(this),
        $input = $container.find('input[type="text"]'),
        $uploadButton = $container.find(".cxf--upload-button"),
        $removeButton = $container.find(".cxf--upload-remove"),
        $previewWrap = $container.find(".cxf--upload-preview"),
        $previewImage = $container.find(".cxf--src"),
        $library =
          ($uploadButton.data("library") &&
            $uploadButton.data("library").split(",")) ||
          [];

      let wpMediaFrame = null;

      settings.library = Array.isArray(settings.library)
        ? settings.library
        : [];

      if (Array.isArray($library) && $library.length > 0) {
        settings.library = $library;
      }

      // Open WordPress Media Library
      $uploadButton.on("click", function (e) {
        e.preventDefault();

        // Check for WordPress media support
        if (typeof window.wp === "undefined" || !window.wp.media) {
          alert("WordPress media library is not available.");
          return;
        }

        // Reuse existing frame or create a new one
        if (!wpMediaFrame) {
          wpMediaFrame = window.wp.media({
            title: "Select a File",
            library: {
              type: settings.library,
            },
            button: {
              text: "Use this file",
            },
            multiple: false,
          });

          // Handle file selection
          wpMediaFrame.on("select", function () {
            const attachment = wpMediaFrame
              .state()
              .get("selection")
              .first()
              .toJSON();

            // Validate file type

            const fileType = (
              attachment.subtype ||
              attachment.type ||
              ""
            ).toLowerCase();

            if (
              settings.library.length &&
              settings.library.indexOf(fileType) === -1
            ) {
              alert("This file type is not allowed.");
              return;
            }

            $input.val(attachment.url).trigger("change");

            if (typeof settings.onFileSelect === "function") {
              settings.onFileSelect(attachment);
            }
          });
        }

        wpMediaFrame.open();
      });

      // Remove file.
      $removeButton.on("click", function (e) {
        e.preventDefault();
        $input.val("").trigger("change");

        if (typeof settings.onFileRemove === "function") {
          settings.onFileRemove();
        }
      });

      // Update preview and toggle visibility.
      $input.on("change", function (e) {
        e.preventDefault();
        const fileUrl = $input.val();

        if (fileUrl) {
          $removeButton.removeClass("hidden");

          if ($previewWrap.length) {
            const fileExtension = fileUrl.split(".").pop().toLowerCase();

            if (
              ["jpg", "jpeg", "gif", "png", "svg", "webp"].includes(
                fileExtension
              )
            ) {
              if ($previewWrap.hasClass("hidden")) {
                $previewWrap.removeClass("hidden");
                $previewImage.attr("src", fileUrl);
              }
            } else {
              $previewWrap.addClass("hidden");
            }
          }
        } else {
          $removeButton.addClass("hidden");
          $previewWrap.addClass("hidden");
        }
      });
    });
  };

  /**
   * Repeater Field
   */
  $.fn.cxfFieldRepeater = function (options) {
    const settings = $.extend(
      {
        wrapperSelector: ".cxf--repeater-wrapper",
        itemSelector: ".cxf--repeater-item",
        cloneableItemSelector: ".cxf--repeater-cloneable",
        addButtonSelector: ".cxf--repeater-add",
        cloneButtonSelector: ".cxf--repeater-clone",
        sortButtonSelector: ".cxf--repeater-sort",
        removeButtonSelector: ".cxf--repeater-remove",
      },
      options
    );
    return this.each(function () {
      const $wrapper = $(settings.wrapperSelector);
      const $repeater = $(this);
      const $fieldId = $wrapper.data("field-id");

      $wrapper.sortable({
        axis: "y",
        handle: settings.sortButtonSelector,
        helper: "original",
        cursor: "move",
        placeholder: "widget-placeholder",
        update: function (event, ui) {
          name_nested_replace($wrapper.find(settings.itemSelector), $fieldId);
        },
      });

      var addItem = function () {
        var $items = $wrapper.find(settings.itemSelector);
        var $cloneableItem = $items.last();
        if (settings.cloneableItemSelector) {
          $cloneableItem = $(settings.cloneableItemSelector);
        }
        const $clonedItem = $cloneableItem.clone();

        const cloneableItemSelectorClass =
          settings.cloneableItemSelector.replace(".", "");

        if ($clonedItem.hasClass(cloneableItemSelectorClass)) {
          $clonedItem.removeClass(cloneableItemSelectorClass);

          $clonedItem.find(':input[name!="_pseudo"]').each(function () {
            this.name = this.name
              .replace("___", "")
              .replace(`${$fieldId}[0]`, `${$fieldId}[${$items.length}]`);
          });

          $wrapper.append($clonedItem);
          $clonedItem.cxf_init();
        }
        // Append new item
        $wrapper.append($clonedItem);
      };

      var cloneItem = function () {
        const $parentItem = $(this).closest(settings.itemSelector);
        if ($parentItem) {
          let $cloneRepeaterButtonItem = $parentItem.clone();
          $wrapper
            .children()
            .eq($parentItem.index())
            .after($cloneRepeaterButtonItem);
          $cloneRepeaterButtonItem.cxf_init();
          name_nested_replace($wrapper.find(settings.itemSelector), $fieldId);
        }
      };

      var removeItem = function () {
        var confirmation = confirm("Are you sure to delete this item?");
        if (confirmation) {
          const $itemToRemove = $(this).closest(settings.itemSelector);
          if ($itemToRemove) {
            $itemToRemove.remove();
          }
        }
      };

      $repeater.on("click", settings.addButtonSelector, addItem);
      $repeater.on("click", settings.cloneButtonSelector, cloneItem);
      $repeater.on("click", settings.removeButtonSelector, removeItem);
    });
  };

  //
  // Reload Plugins
  //
  $.fn.cxf_init = function (options) {
    var settings = $.extend({}, options);

    return this.each(function () {
      var $this = $(this);

      // Avoid for conflicts.
      if (!$this.data("inited")) {
        $this.find(".cxf--field-repeater").cxfFieldRepeater();
        $this.find(".cxf--field-upload").cxfBuilderFileUpload();

        $("[data-depends]").cxfDependsOn({
          // Optional settings
          triggerInitial: true,
          debug: true,
          onEnable: function () {
            // console.log("Element enabled:", this);
          },
          onDisable: function () {
            // console.log("Element disabled:", this);
          },
        });

        $this.data("inited", true);
        $(document).trigger("cxf--reload-script", $this);
      }
    });
  };

  $(".cxf--builder-init").cxf_init();

  $(".cxf--animation-settings-save").on("click", function (e) {
    var self = $(this);
    var forms = self.closest("form");

    let saveButtonText = self.html();

    $.ajax({
      url: CXF_ADMIN_LOCALIZE_JS.ajax_url,
      data: {
        action: "cxf_settings_store",
        cxf_nonce: CXF_ADMIN_LOCALIZE_JS.cxf_nonce,
        settings: forms.attr("name"),
        form: forms.serialize(),
      },
      type: "POST",
      beforeSend: function beforeSend() {
        self.html("Saving Data...");
      },
      success: function success(response) {
        // console.log(response);
      },
      complete: function complete(response) {
        // console.log(response);
        self.html(saveButtonText);
      },
      error: function error(err) {
        // console.log(err);
      },
    });
  });
})(jQuery, window, document);
