﻿using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace SynchronisationDataManager.Clients
{
    public abstract class DatabaseClient
    {
        protected abstract void Connect();
        protected abstract void Close();
        public abstract void BeginTransaction();
        public abstract void RollbackTransaction();
        public abstract void CommitTransaction();
        protected abstract DataTable ExecuteQuery(string query);

        public DataTable ExecuteQuery(string query, List<Object> insertParamValues)
        {
            if(null != insertParamValues)
            {
             // maybe neccesary
            }
            return ExecuteQuery(query);
        }

    }
}
