import { Notyf } from 'notyf'

const notyf = new Notyf({
  duration: 2000,
  position: {
    x: 'right',
    y: 'bottom',
  },
  types: [
    {
      type: 'warning',
      icon: {
        className: 'fas fa-hand-paper',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'info',
      icon: {
        className: 'fas fa-info-circle',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'primary',
      icon: {
        className: 'fas fa-car-crash',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'accent',
      icon: {
        className: 'fas fa-car-crash',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'purple',
      icon: {
        className: 'fas fa-check',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'blue',
      icon: {
        className: 'fas fa-check',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'green',
      icon: {
        className: 'fas fa-check',
        tagName: 'i',
        text: '',
      },
    },
    {
      type: 'orange',
      icon: {
        className: 'fas fa-check',
        tagName: 'i',
        text: '',
      },
    },
  ],
});

export default function useNotify() {
  return {
    dismiss: (notification) => {
      notyf.dismiss(notification)
    },
    dismissAll: () => {
      notyf.dismissAll()
    },
    success: (payload) => {
      return notyf.success(payload)
    },
    error: (payload) => {
      return notyf.error(payload)
    },
    info: (payload) => {
      const options = {
        type: 'info',
      };

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    warning: (payload) => {
      const options = {
        type: 'warning',
      };

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    primary: (payload) => {
      const options = {
        type: 'primary',
      };

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    purple: (payload) => {
      const options = {
        type: 'purple',
      }

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    blue: (payload) => {
      const options = {
        type: 'blue',
      }

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    green: (payload) => {
      const options = {
        type: 'green',
      }

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
    orange: (payload) => {
      const options = {
        type: 'orange',
      }

      if (typeof payload === 'string') {
        options.message = payload
      } else {
        Object.assign(options, payload)
      }

      return notyf.open(options)
    },
  }
}
