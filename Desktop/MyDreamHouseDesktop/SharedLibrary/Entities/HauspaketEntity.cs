using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary
{
    public class HauspaketEntity
    {
        public int HauspaketId { get; set; }

        public int HerstellerId { get; set; }

        public int BeraterId { get; set; }

        public string Bezeichnung { get; set; }

        public decimal Preis { get; set; }

        public decimal Grundflaeche { get; set; }

        public decimal Wohnflaeche { get; set; }

        public int Stockwerke { get; set; }

        public int BenutzerId { get; set; }

        public bool Archived { get; set; }
    }
}
