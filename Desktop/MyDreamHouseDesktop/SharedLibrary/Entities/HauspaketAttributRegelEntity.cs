using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SharedLibrary.Entities
{
    public class HauspaketAttributRegelEntity
    {
        public int RegelId { get; set; }

        public int RegelAttributLeftId { get; set; }

        public int RegelAttributRightId { get; set; }

        public decimal RegelPreisModifikator { get; set; }

        public bool RegelErlaubt { get; set; }
    }
}
