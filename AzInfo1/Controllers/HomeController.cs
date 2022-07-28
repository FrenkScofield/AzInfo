﻿using AzInfo1.Models;
using Microsoft.AspNetCore.Mvc;
using Microsoft.Extensions.Logging;
using System;
using System.Collections.Generic;
using System.Diagnostics;
using System.Linq;
using System.Threading.Tasks;

namespace AzInfo1.Controllers
{
    public class HomeController : Controller
    {
        private readonly ILogger<HomeController> _logger;

        public HomeController(ILogger<HomeController> logger)
        {
            _logger = logger;
        }

        public IActionResult Index()
        {
            return View();
        }
        public IActionResult hakkimizda()
        {
            return View();
        }
        public IActionResult hizmetler()
        {
            return View();
        }
        public IActionResult urunler()
        {
            return View();
        }
        public IActionResult referanslar()
        {
            return View();
        }
        public IActionResult iletisim()
        {
            return View();
        }
        public IActionResult bakteriUygulamalari()
        {
            return View();
        }
        public IActionResult buharUretimSistemKilimalari()
        {
            return View();
        }
        public IActionResult sogutmaKulesiSistemleri()
        {
            return View();
        }
        public IActionResult kapaliDevreSistemleri()
        {
            return View();
        }
        public IActionResult dezenfeksiyonUrunleri()
        {
            return View();
        }

        [ResponseCache(Duration = 0, Location = ResponseCacheLocation.None, NoStore = true)]
        public IActionResult Error()
        {
            return View(new ErrorViewModel { RequestId = Activity.Current?.Id ?? HttpContext.TraceIdentifier });
        }
    }
}
