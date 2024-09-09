const app = {
  host: "http://localhost",
  port: "5000",
  setLocal: (key, value) => {
    try {
      localStorage.setItem(key, JSON.stringify(value));
    } catch (error) {
      console.error("Error saving to localStorage", error);
    }
  },
  getLocal: (key) => {
    try {
      const value = localStorage.getItem(key);
      return value ? JSON.parse(value) : null;
    } catch (error) {
      console.error("Error getting from localStorage", error);
      return null;
    }
  },

  ajaxRequest: (method, url, data = {}, token = "") => {
    const startTime = performance.now(); // Bắt đầu ghi lại thời gian
    return $.ajax({
      url: url,
      type: method,
      data: JSON.stringify(data),
      contentType: "application/json",
      headers: {
        Authorization: `Bearer ${token}`,
      },
      success: (response) => {
        const endTime = performance.now(); // Kết thúc ghi lại thời gian
        console.log(
          `Request ${method} to ${url} completed in ${endTime - startTime} ms`
        );
        console.log(
          `Success [${Math.floor(endTime - startTime)} ms]:`,
          response
        );
      },
      error: (xhr, status, error) => {
        const endTime = performance.now();
        console.error(`Error [${Math.floor(endTime - startTime)} ms]:`, error);
      },
    });
  },
  get: (url, token = "") =>
    app.ajaxRequest("GET", app.host + ":" + app.port + "/api" + url, {}, token),
  post: (url, data = {}, token = "") =>
    app.ajaxRequest(
      "POST",
      app.host + ":" + app.port + "/api" + url,
      data,
      token
    ),
  patch: (url, data = {}, token = "") =>
    app.ajaxRequest(
      "PATCH",
      app.host + ":" + app.port + "/api" + url,
      data,
      token
    ),
  delete: (url, token = "") =>
    app.ajaxRequest(
      "DELETE",
      app.host + ":" + app.port + "/api" + url,
      {},
      token
    ),
};
